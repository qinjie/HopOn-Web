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
        $rental->user_id = $userId;
        $rental->bicycle_id = $selectedBicycle->id;
        $rental->serial = $selectedBicycle->serial;
        $rental->book_at = date('Y-m-d H:i:s');

        if ($selectedBicycle->save() && $rental->save())
            return $selectedBicycle;
    }

    public function actionReturn() {
        $userId = Yii::$app->user->identity->id;
        $bodyParams = Yii::$app->request->bodyParams;
        $bicycleId = $bodyParams['bicycleId'];
        $latitude = $bodyParams['latitude'];
        $longitude = $bodyParams['longitude'];

        $stationBeaconUUID = $bodyParams['stationBeaconUUID'];
        $stationBeaconMajor = $bodyParams['stationBeaconMajor'];
        $stationBeaconMinor = $bodyParams['stationBeaconMinor'];
        $station = Yii::$app->db->createCommand('
            select station.id
             from station join beacon on station.beacon_id = beacon.id
             where uuid = :uuid
             and major = :major
             and minor = :minor
        ')
        ->bindValue(':uuid', $stationBeaconUUID)
        ->bindValue(':major', $stationBeaconMajor)
        ->bindValue(':minor', $stationBeaconMinor)
        ->queryOne();

        $rental = Rental::findOne([
            'user_id' => $userId, 
            'return_at' => null,
            'bicycle_id' => $bicycleId,
        ]);
        if (!$rental) throw new BadRequestHttpException('Invalid rental data');
        $rental->return_at = date('Y-m-d H:i:s');
        $rental->return_station_id = $station['id'];
        $rental->duration = intval(ceil((strtotime($rental->return_at) - strtotime($rental->book_at)) / 60));
        $bicycle = Bicycle::findOne(['id' => $bicycleId]);
        $bicycle->status = Bicycle::STATUS_FREE;

        $bicycleLocation = new BicycleLocation();
        $bicycleLocation->bicycle_id = $bicycleId;
        $bicycleLocation->user_id = $userId;
        $bicycleLocation->latitude = $latitude;
        $bicycleLocation->longitude = $longitude;
        if ($rental->save() && $bicycle->save() && $bicycleLocation->save())
            return $rental;
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

        $bicycleLocation = new BicycleLocation();
        $bicycleLocation->bicycle_id = $bicycleId;
        $bicycleLocation->user_id = $userId;
        $bicycleLocation->latitude = $latitude;
        $bicycleLocation->longitude = $longitude;
        if ($rental->pickup_at) {
            $bicycle->status = Bicycle::STATUS_UNLOCKED;
            if ($bicycle->save() && $bicycleLocation->save())
                return $rental;
        } else {
            $rental->pickup_at = date('Y-m-d H:i:s');
            $bicycle->status = Bicycle::STATUS_UNLOCKED;
            if ($rental->save() && $bicycle->save() && $bicycleLocation->save())
                return $rental;
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

        $bicycleLocation = new BicycleLocation();
        $bicycleLocation->bicycle_id = $bicycleId;
        $bicycleLocation->user_id = $userId;
        $bicycleLocation->latitude = $latitude;
        $bicycleLocation->longitude = $longitude;
        if ($bicycle->save() && $bicycleLocation->save())
            return $rental;
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