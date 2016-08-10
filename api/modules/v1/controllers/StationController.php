<?php

namespace api\modules\v1\controllers;

use api\common\controllers\CustomActiveController;
use api\common\helpers\TokenHelper;
use api\common\models\UserToken;
use api\common\models\User;
use api\common\components\AccessRule;
use api\common\models\SignupModel;
use api\common\models\LoginModel;
use api\common\models\ChangePasswordModel;
use api\common\models\PasswordResetModel;

use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;

class StationController extends CustomActiveController
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
                    'actions' => ['list-station', 'detail'],
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

    public function actionListStation() {
        $listStation = Yii::$app->db->createCommand('
            select id, 
                   name, 
                   address, 
                   latitude, 
                   longitude, 
                   postal, 
                   bicycle_count 
             from station
        ')
        ->queryAll();
        return $listStation;
    }

    public function actionDetail($stationId) {
        $listBikeModel = Yii::$app->db->createCommand('
            select bicycle_type.id as bicycle_type_id, 
                   brand, 
                   model, 
                   count(bicycle.id) as number_bicycle 
             from bicycle_type join bicycle on bicycle.bicycle_type_id = bicycle_type.id
             group by bicycle_type_id, brand, model
        ')
        ->queryAll();
        return $listBikeModel;
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