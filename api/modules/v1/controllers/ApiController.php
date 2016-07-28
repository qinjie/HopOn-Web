<?php
namespace api\modules\v1\controllers;

use api\common\controllers\CustomActiveController;
use api\common\models\User;
use api\common\components\AccessRule;

use yii\rest\Controller;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\web\UnauthorizedHttpException;
use yii\web\BadRequestHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;

class ApiController extends CustomActiveController {

    public function behaviors() {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'except' => ['home', 'error'],
        ];

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'ruleConfig' => [
                'class' => AccessRule::className(),
            ],
            'rules' => [
                [   
                    'actions' => ['home'],
                    'allow' => true,
                    'roles' => ['?'],
                ],
                [
                    'actions' => ['error'],
                    'allow' => false,
                ]
            ],

            'denyCallback' => function ($rule, $action) {
                throw new UnauthorizedHttpException('You are not authorized');
            },
        ];

        return $behaviors;
    }

    public function actionHome() {
        return 'Welcome to HopOn';
    }

    public function actionError() {
        $error = Yii::$app->errorHandler->error;
        return $error->message;
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
