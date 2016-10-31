<?php

namespace api\modules\v1\controllers;

use api\common\controllers\CustomActiveController;
use api\common\helpers\TokenHelper;
use api\common\models\UserToken;
use api\common\models\User;
use api\common\components\AccessRule;
use api\modules\v1\models\Bicycle;
use api\modules\v1\models\Rental;

use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;

class RentalController extends CustomActiveController
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
                    'actions' => ['current-booking', 'history'],
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

    public function actionCurrentBooking() {
        $userId = Yii::$app->user->identity->id;
        $currentBooking = Yii::$app->db->createCommand('
            select rental.id as rental_id,
                  rental.booking_id,
                  bicycle_id,
                  bicycle.serial as bicycle_serial,
                  bicycle.desc,
                  bicycle_type.brand,
                  bicycle_type.model,
                  station.name as pickup_station_name,
                  station.address as pickup_station_address,
                  station.postal as pickup_station_postal,
                  station.latitude as pickup_station_lat,
                  station.longitude as pickup_station_lng,
                  rental.book_at,
                  rental.pickup_at,
                  b1.uuid as beacon_station_uuid,
                  b1.major as beacon_station_major,
                  b1.minor as beacon_station_minor,
                  b2.uuid as beacon_bicycle_uuid,
                  b2.major as beacon_bicycle_major,
                  b2.minor as beacon_bicycle_minor,
                  bean2.name as bean_bicycle_name,
                  bean2.address as bean_bicycle_address,
                  status,
                  (select group_concat(data separator \' \') 
                    from image 
                    where image.bicycle_type_id = bicycle_type.id) as listImageUrl
             from rental join bicycle on rental.bicycle_id = bicycle.id
             join bicycle_type on bicycle.bicycle_type_id = bicycle_type.id
             join station on rental.pickup_station_id = station.id
             join beacon as b1 on b1.id = station.beacon_id
             join beacon as b2 on b2.id = bicycle.beacon_id
             join bean as bean2 on bean2.id = b2.bean_id
             where user_id = :userId
             and return_at is null
        ')
        ->bindValue(':userId', $userId)
        ->queryOne();
        if (!$currentBooking) throw new BadRequestHttpException('No booking');
        $time = strtotime($currentBooking['book_at']);
        $currentBooking['book_at'] = date('h:i A, d M Y', $time);
        if ($currentBooking['pickup_at']) {
            $time = strtotime($currentBooking['pickup_at']);
            $currentBooking['pickup_at'] = date('h:i A, d M Y', $time);
        }
        $currentBooking['listImageUrl'] = explode(' ', $currentBooking['listImageUrl']);
        for ($iterUrl = 0; $iterUrl < count($currentBooking['listImageUrl']); ++$iterUrl) {
            $currentBooking['listImageUrl'][$iterUrl] = Yii::$app->params['BACKEND_BASEURL'].$currentBooking['listImageUrl'][$iterUrl];
        }
        $currentBooking['user_id'] = $userId;
        $authKey = Yii::$app->user->identity->auth_key;
        $currentBooking['auth_key'] = $authKey;
        $currentBooking['enc'] = md5($currentBooking['bicycle_serial'].','.$authKey);
        return $currentBooking;
    }

    public function actionHistory() {
        $userId = Yii::$app->user->identity->id;
        $history = Yii::$app->db->createCommand('
            select rental.id as rental_id,
                   rental.booking_id,
                   bicycle_id,
                   bicycle.serial as bicycle_serial,
                   bicycle.desc,
                   bicycle_type.brand,
                   bicycle_type.model,
                   s1.name as pickup_station_name,
                   s1.address as pickup_station_address,
                   s1.postal as pickup_station_postal,
                   s1.latitude as pickup_station_lat,
                   s1.longitude as pickup_station_lng,
                   rental.book_at,
                   rental.pickup_at,
                   rental.return_at,
                   rental.duration,
                   s2.name as return_station_name,
                   s2.address as return_station_address,
                   s2.postal as return_station_postal,
                   s2.latitude as return_station_lat,
                   s2.longitude as return_station_lng
             from rental join bicycle on rental.bicycle_id = bicycle.id
             join bicycle_type on bicycle.bicycle_type_id = bicycle_type.id
             join station as s1 on rental.pickup_station_id = s1.id
             join station as s2 on rental.return_station_id = s2.id
             where user_id = :userId
             and return_at is not null
             order by return_at desc
        ')
        ->bindValue(':userId', $userId)
        ->queryAll();

        for ($iter = 0; $iter < count($history); ++$iter) {
            $time = strtotime($history[$iter]['book_at']);
            $history[$iter]['book_at'] = date('h:i A, d M Y', $time);
            if ($history[$iter]['pickup_at']) {
              $time = strtotime($history[$iter]['pickup_at']);
              $history[$iter]['pickup_at'] = date('h:i A, d M Y', $time);
            }
            $time = strtotime($history[$iter]['return_at']);
            $history[$iter]['return_at'] = date('h:i A, d M Y', $time);
        }

        return $history;
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