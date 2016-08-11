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
                    'actions' => ['current-booking'],
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
            select rental.id as booking_id,
                   bicycle_id,
                   bicycle.serial as bicycle_serial,
                   bicycle.desc,
                   bicycle_type.brand,
                   bicycle_type.model,
                   station.name as pickup_station_name,
                   station.address as pickup_station_address,
                   station.postal as pickup_station_postal,
                   rental.book_at,
                   rental.pickup_at,
                   b1.uuid as beacon_station_uuid,
                   b1.major as beacon_station_major,
                   b1.minor as beacon_station_minor,
                   b2.uuid as beacon_bicycle_uuid,
                   b2.major as beacon_bicycle_major,
                   b2.minor as beacon_bicycle_minor
             from rental join bicycle on rental.bicycle_id = bicycle.id
             join bicycle_type on bicycle.bicycle_type_id = bicycle_type.id
             join station on bicycle.station_id = station.id
             join beacon as b1 on b1.id = station.beacon_id
             join beacon as b2 on b2.id = bicycle.beacon_id
             where user_id = :userId
             and return_at is null
        ')
        ->bindValue(':userId', $userId)
        ->queryOne();
        $time = strtotime($currentBooking['book_at']);
        $currentBooking['book_at'] = date('h:i A, d M Y', $time);
        return $currentBooking;
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