<?php

namespace api\modules\v1\controllers;

use api\common\controllers\CustomActiveController;
use api\common\helpers\TokenHelper;
use api\common\models\UserToken;
use api\common\models\User;
use api\common\components\AccessRule;
use api\modules\v1\models\Bicycle;
use api\modules\v1\models\BicycleLocation;
use api\modules\v1\models\Rental;
use api\modules\v1\models\Station;
use api\common\helpers\AES;

use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;

class BicycleController extends CustomActiveController
{
    public $modelClass = '';

    public function behaviors() {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
        ];

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'ruleConfig' => [
                'class' => AccessRule::className(),
            ],
            'rules' => [
                [
                    'actions' => ['book', 'return', 'unlock', 'lock'],
                    'allow' => true,
                    'roles' => ['@'],
                ]
            ],
            'denyCallback' => function ($rule, $action) {
                throw new UnauthorizedHttpException('You are not authorized');
            },
        ];

        return $behaviors;
    }

    private function alreadyBook($userId) {
        $rental = Rental::findOne(['user_id' => $userId, 'return_at' => null]);
        return $rental;
    }

    public function actionBook() {
        $userId = Yii::$app->user->identity->id;
        if ($this->alreadyBook($userId)) throw new BadRequestHttpException('You already book a bicycle');
        $bodyParams = Yii::$app->request->bodyParams;
        $stationId = $bodyParams['stationId'];
        $bicycleTypeId = $bodyParams['bicycleTypeId'];

        $listBicycle = Bicycle::findAll([
            'station_id' => $stationId,
            'bicycle_type_id' => $bicycleTypeId,
            'status' => Bicycle::STATUS_FREE,
        ]);
        $randomNumber = rand(0, count($listBicycle) - 1);
        $selectedBicycle = $listBicycle[$randomNumber];
        $selectedBicycle->status = Bicycle::STATUS_BOOKED;

        $rental = new Rental();
        $rental->booking_id = strtoupper(uniqid("SG"));
        $rental->pickup_station_id = $stationId;
        $rental->user_id = $userId;
        $rental->bicycle_id = $selectedBicycle->id;
        $rental->serial = $selectedBicycle->serial;
        $rental->book_at = date('Y-m-d H:i:s');

        if ($selectedBicycle->save() && $rental->save()) {
            $bicycle = Yii::$app->db->createCommand('
                select bicycle.id as bicycle_id,
                       bicycle.serial,
                       bicycle_type.brand,
                       bicycle_type.model,
                       station.name as station_name,
                       station.address,
                       station.postal
                from bicycle join bicycle_type on bicycle_type_id = bicycle_type.id
                join station on bicycle.station_id = station.id
                where bicycle.id = :bicycleId
            ')
            ->bindValue(':bicycleId', $selectedBicycle->id)
            ->queryOne();
            $user = Yii::$app->user->identity;

            Yii::$app->mailer->compose(['html' => '@common/mail/bookingDetail-html'], [
                    'bicycle' => $bicycle, 
                    'rental' => $rental,
                    'user' => $user,
                ])
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                ->setTo($user->email)
                ->setSubject('Booking Detail From ' . Yii::$app->name)
                ->send();
            $result = $selectedBicycle->attributes;
            $result['enc'] = md5($selectedBicycle->serial.','.Yii::$app->user->identity->auth_key);
            return $result;
        }
        throw new BadRequestHttpException('Cannot save database');
    }

    private function addBicycleLocation($bicycleId, $latitude, $longitude) {
        $userId = Yii::$app->user->identity->id;
        $bicycleLocation = new BicycleLocation();
        $bicycleLocation->bicycle_id = $bicycleId;
        $bicycleLocation->user_id = $userId;
        $bicycleLocation->latitude = $latitude;
        $bicycleLocation->longitude = $longitude;
        return $bicycleLocation->save();
    }

    public function actionReturn() {
        $userId = Yii::$app->user->identity->id;
        $bodyParams = Yii::$app->request->bodyParams;
        $bicycleId = $bodyParams['bicycleId'];
        $latitude = $bodyParams['latitude'];
        $longitude = $bodyParams['longitude'];
        $listBeacons = $bodyParams['listBeacons'];
        $beaconsRSSI = [];
        for ($iter = 0; $iter < count($listBeacons); ++$iter) {
            $key = $listBeacons[$iter]['uuid'].','.$listBeacons[$iter]['major'].','.$listBeacons[$iter]['minor'];
            $beaconsRSSI[$key] = $listBeacons[$iter]['rssi'];
        }

        $rental = Rental::findOne([
            'user_id' => $userId, 
            'return_at' => null,
            'bicycle_id' => $bicycleId,
        ]);
        if (!$rental) throw new BadRequestHttpException('Invalid rental data');

        $bicycle = Bicycle::findOne(['id' => $bicycleId]);

        $sql = 'select station.id, uuid, major, minor from station join beacon on station.beacon_id = beacon.id where (uuid = "" and major = "" and minor = "")';
        for ($iter = 0; $iter < count($listBeacons); ++$iter) {
            $uuid = $listBeacons[$iter]['uuid'];
            $major = $listBeacons[$iter]['major'];
            $minor = $listBeacons[$iter]['minor'];
            $sql = $sql.' or (uuid = "'.$uuid.'" and major = "'.$major.'" and minor = "'.$minor.'")';
        }
        $sql = $sql.';';

        $listStation = Yii::$app->db->createCommand($sql)->queryAll();
        $station = null;
        for ($iter = 0; $iter < count($listStation); ++$iter) {
            $key = $listStation[$iter]['uuid'].','.$listStation[$iter]['major'].','.$listStation[$iter]['minor'];
            if (!$station) {
                $station = $listStation[$iter];
                $station['rssi'] = $beaconsRSSI[$key];
            } else if ($station['rssi'] < $beaconsRSSI[$key]) {
                $station = $listStation[$iter];
                $station['rssi'] = $beaconsRSSI[$key];
            }
        }
        
        if ($rental->pickup_at) {
            if (!$station) throw new BadRequestHttpException('Invalid beacon data');
            $rental->return_at = date('Y-m-d H:i:s');
            $rental->return_station_id = $station['id'];
            $rental->duration = intval(ceil((strtotime($rental->return_at) - strtotime($rental->book_at)) / 60));
            $bicycle->status = Bicycle::STATUS_FREE;
            $bicycle->station_id = $station['id'];
        } else {
            $rental->return_at = date('Y-m-d H:i:s');
            $rental->return_station_id = $bicycle->station_id;
            $rental->duration = intval(ceil((strtotime($rental->return_at) - strtotime($rental->book_at)) / 60));
            $bicycle->status = Bicycle::STATUS_FREE;
        }

        if ($rental->save() && $bicycle->save() 
            && $this->addBicycleLocation($bicycleId, $latitude, $longitude)) {
            $result = Yii::$app->db->createCommand('
                select rental.id as booking_id,
                       bicycle_type.brand,
                       bicycle_type.model,
                       s1.name as pickup_station_name,
                       s1.address as pickup_station_address,
                       s1.postal as pickup_station_postal,
                       rental.book_at,
                       rental.pickup_at,
                       rental.return_at,
                       rental.duration,
                       s2.name as return_station_name,
                       s2.address as return_station_address,
                       s2.postal as return_station_postal
                from rental join bicycle on rental.bicycle_id = bicycle.id
                join bicycle_type on bicycle.bicycle_type_id = bicycle_type.id
                join station as s1 on rental.pickup_station_id = s1.id
                join station as s2 on rental.return_station_id = s2.id
                where user_id = :userId
                and rental.id = :rentalId
            ')
            ->bindValue(':userId', $userId)
            ->bindValue(':rentalId', $rental->id)
            ->queryOne();
            $user = Yii::$app->user->identity;

            Yii::$app->mailer->compose(['html' => '@common/mail/tripSummary-html'], [
                    'booking' => $result,
                    'user' => $user,
                ])
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                ->setTo($user->email)
                ->setSubject('Trip Summary From ' . Yii::$app->name)
                ->send();

            return $rental;
        }
        throw new BadRequestHttpException('Return fail');
    }

    public function actionUnlock() {
        $userId = Yii::$app->user->identity->id;
        $bodyParams = Yii::$app->request->bodyParams;
        $bicycleId = $bodyParams['bicycleId'];
        $latitude = $bodyParams['latitude'];
        $longitude = $bodyParams['longitude'];

        $rental = Rental::findOne([
            'user_id' => $userId, 
            'return_at' => null,
            'bicycle_id' => $bicycleId,
        ]);
        if (!$rental) throw new BadRequestHttpException('Cannot unlock bicycle');
        $bicycle = Bicycle::findOne(['id' => $bicycleId]);

        if ($rental->pickup_at) {
            $bicycle->status = Bicycle::STATUS_UNLOCKED;
            if ($bicycle->save() && $this->addBicycleLocation($bicycleId, $latitude, $longitude)) {
                $time = strtotime($rental->pickup_at);
                $rental->pickup_at = date('h:i A, d M Y', $time);
                $result = $rental->attributes;
                $result['enc'] = md5($bicycleId.',unlock,'.$userId);
                return $result;
            }
        } else {
            $rental->pickup_at = date('Y-m-d H:i:s');
            $bicycle->status = Bicycle::STATUS_UNLOCKED;
            if ($rental->save() && $bicycle->save()
                && $this->addBicycleLocation($bicycleId, $latitude, $longitude)) {
                $time = strtotime($rental->pickup_at);
                $rental->pickup_at = date('h:i A, d M Y', $time);
                return $rental;
            }
        }
        throw new BadRequestHttpException('unlock fail');
    }

    public function actionLock() {
        $userId = Yii::$app->user->identity->id;
        $bodyParams = Yii::$app->request->bodyParams;
        $bicycleId = $bodyParams['bicycleId'];
        $latitude = $bodyParams['latitude'];
        $longitude = $bodyParams['longitude'];

        $rental = Rental::findOne([
            'user_id' => $userId, 
            'return_at' => null,
            'bicycle_id' => $bicycleId,
        ]);
        if (!$rental) throw new BadRequestHttpException('Cannot lock bicycle');
        $bicycle = Bicycle::findOne(['id' => $bicycleId]);
        $bicycle->status = Bicycle::STATUS_LOCKED;

        // $aes = new AES('bicycleId='.$bicycleId.',action=lock', Yii::$app->params['AES_KEY'], 128);
        if ($bicycle->save() && $this->addBicycleLocation($bicycleId, $latitude, $longitude)) {
            // $result = $rental->attributes;
            // $result['enc'] = bin2hex(base64_decode($aes->encrypt()));
            // $result['enc'] = md5($bicycle->serial.','.$userId);
            return $rental;
        }
        throw new BadRequestHttpException('unlock fail');
    }

    // public function afterAction($action, $result)
    // {
    //     $result = parent::afterAction($action, $result);
    //     // your custom code here
    //     return [
    //         'status' => '200',
    //         'data' => $result,
    //     ];
    // }
}