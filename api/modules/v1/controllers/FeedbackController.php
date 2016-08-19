<?php
namespace api\modules\v1\controllers;

use api\common\controllers\CustomActiveController;
use api\common\models\User;
use api\common\components\AccessRule;
use api\modules\v1\models\Feedback;
use api\modules\v1\models\Rental;

use yii\rest\Controller;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\web\UnauthorizedHttpException;
use yii\web\BadRequestHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;

class FeedbackController extends CustomActiveController {

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
                    'actions' => ['new'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],

            'denyCallback' => function ($rule, $action) {
                throw new UnauthorizedHttpException('You are not authorized');
            },
        ];

        return $behaviors;
    }

    public function actionNew() {
        $userId = Yii::$app->user->identity->id;
        $bodyParams = Yii::$app->request->bodyParams;
        $rentalId = $bodyParams['rentalId'];
        $listIssue = $bodyParams['listIssue'];
        $comment = $bodyParams['comment'];
        $rating = $bodyParams['rating'];

        $rental = Rental::findOne(['id' => $rentalId]);
        if (!$rental || $rental->user_id != $userId)
            throw new BadRequestHttpException('Invalid booking id');

        $feedback = new Feedback();
        $feedback->rental_id = $rentalId;
        $feedback->issue = '['.implode(',', $listIssue).']';
        $feedback->comment = $comment;
        $feedback->rating = $rating;
        if ($feedback->save())
            return 'Feedback saved';
        throw new BadRequestHttpException('Cannot save feedback');
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
