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
use api\common\models\ChangeEmailModel;

use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;

class UserController extends CustomActiveController
{
    public $modelClass = '';

    const CODE_INCORRECT_USERNAME = 0;
    const CODE_INCORRECT_PASSWORD = 1;
    const CODE_UNVERIFIED_EMAIL = 3;
    const CODE_INVALID_ACCOUNT = 6;
    const CODE_INVALID_PASSWORD = 8;
    const CODE_INVALID_EMAIL = 10;
    const CODE_INVALID_PHONE = 11;
    const CODE_INVALID_FULLNAME = 12;
    
    public function behaviors() {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'except' => ['login', 'signup', 'reset-password',
                'resend-email', 'activate', 'activate-email'],
        ];

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'ruleConfig' => [
                'class' => AccessRule::className(),
            ],
            'rules' => [
                [   
                    'actions' => ['login', 'signup', 'reset-password',
                        'resend-email', 'activate', 'activate-email'],
                    'allow' => true,
                    'roles' => ['?'],
                ],
                [
                    'actions' => ['logout', 'change-password', 'profile', 
                        'change-email'],
                    'allow' => true,
                    'roles' => ['@'],
                ]
            ],
            'denyCallback' => function ($rule, $action) {
                throw new UnauthorizedHttpException('You are not authorized');
            },
        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'login' => ['post'],
                'signup' => ['post'],
                'logout' => ['get']
            ],
        ];

        return $behaviors;
    }

    public function actionLogin() {
    	$request = Yii::$app->request;
    	$bodyParams = $request->bodyParams;
        $username = $bodyParams['username'];
        $password = $bodyParams['password'];

    	$model = new LoginModel();
    	$model->username = $username;
    	$model->password = $password;
    	if ($user = $model->login()) {
            if ($user->status == User::STATUS_WAIT_EMAIL)
                throw new BadRequestHttpException(null, self::CODE_UNVERIFIED_EMAIL);
            if ($user->status == User::STATUS_ACTIVE) {
                UserToken::deleteAll(['user_id' => $user->id, 'action' => TokenHelper::TOKEN_ACTION_ACCESS]);
                $token = TokenHelper::createUserToken($user->id);
                return [
                    'token' => $token->token,
                    'fullname' => $user->fullname,
                ];
            } else throw new BadRequestHttpException(null, self::CODE_INVALID_ACCOUNT);
    	} else {
            if (isset($model->errors['username']))
                throw new BadRequestHttpException(null, self::CODE_INCORRECT_USERNAME);
            if (isset($model->errors['password']))
                throw new BadRequestHttpException(null, self::CODE_INCORRECT_PASSWORD);
        }
        throw new BadRequestHttpException('Invalid data');
    }

    public function actionSignup() {
    	$bodyParams = Yii::$app->request->bodyParams;

    	$model = new SignupModel();
    	$model->fullname = $bodyParams['fullname'];
        $model->mobile = $bodyParams['mobile'];
    	$model->email = $bodyParams['email'];
    	$model->password = $bodyParams['password'];
        $model->role = isset($bodyParams['role']) ? $bodyParams['role'] : User::ROLE_USER;
		if ($user = $model->signup()) {
            return 'register successfully';
		} else {
            if (isset($model->errors['fullname']))
                throw new BadRequestHttpException(null, self::CODE_INVALID_FULLNAME);
            if (isset($model->errors['mobile']))
                throw new BadRequestHttpException(null, self::CODE_INVALID_PHONE);
            if (isset($model->errors['email']))
                throw new BadRequestHttpException(null, self::CODE_INVALID_EMAIL);
            if (isset($model->errors['password']))
                throw new BadRequestHttpException(null, self::CODE_INVALID_PASSWORD);
        }
        throw new BadRequestHttpException('Invalid data');
    }

    public function actionResendEmail() {
        $bodyParams = Yii::$app->request->bodyParams;
        $email = $bodyParams['email'];
        $user = User::findOne(['email' => $email]);
        if ($user) {
            $userToken = UserToken::findOne(['user_id' => $user->id, 'action' => TokenHelper::TOKEN_ACTION_ACTIVATE_ACCOUNT]);
            if ($userToken) {
                Yii::$app->mailer->compose(['html' => '@common/mail/emailConfirmToken-html'], ['user' => $user, 'token' => $userToken->token])
                    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                    ->setTo($email)
                    ->setSubject('Email confirmation for ' . Yii::$app->name)
                    ->send();
                return 'resend email';
            }
        }
        throw new BadRequestHttpException('Invalid data');
    }

    public function actionActivate() {
        $bodyParams = Yii::$app->request->bodyParams;
        $token = $bodyParams['token'];
        $email = $bodyParams['email'];
        $userId = TokenHelper::authenticateToken($token, true, TokenHelper::TOKEN_ACTION_ACTIVATE_ACCOUNT);
        $user = User::findOne([
            'id' => $userId, 
            'status' => User::STATUS_WAIT_EMAIL,
        ]);
        if (!$user || $user->email != $email) throw new BadRequestHttpException('Invalid token');
        $user->status = User::STATUS_ACTIVE;
        UserToken::removeEmailConfirmToken($user->id);
        if ($user->save()) {
            $token = TokenHelper::createUserToken($user->id);
            Yii::$app->mailer->compose(['html' => '@common/mail/accountCreation-html'], ['user' => $user])
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                ->setTo($user->email)
                ->setSubject('Congratulates. You have successfully activated your account in ' . Yii::$app->name)
                ->send();
            return [
                'token' => $token->token,
                'fullname' => $user->fullname,
            ];
        }
        throw new BadRequestHttpException('Cannot change user status');
    }

    public function actionLogout() {
    	$id = Yii::$app->user->identity->id;
    	UserToken::deleteAll(['user_id' => $id, 'action' => TokenHelper::TOKEN_ACTION_ACCESS]);
		return 'logout successfully';
    }

    public function actionChangePassword() {
        $user = Yii::$app->user->identity;
        $bodyParams = Yii::$app->request->bodyParams;

        $model = new ChangePasswordModel();
        $model->user = $user;
        $model->oldPassword = $bodyParams['oldPassword'];
        $model->newPassword = $bodyParams['newPassword'];
        if ($model->changePassword())
            return 'change password successfully';
        else {
            if (isset($model->errors['oldPassword']))
                throw new BadRequestHttpException(null, self::CODE_INCORRECT_PASSWORD);
            if (isset($model->errors['newPassword']))
                throw new BadRequestHttpException(null, self::CODE_INVALID_PASSWORD);
        }
        throw new BadRequestHttpException('Invalid data');
    }

    public function actionResetPassword() {
        $bodyParams = Yii::$app->request->bodyParams;
        $email_mobile = $bodyParams['email_mobile'];

        $model = new PasswordResetModel();
        $model->email_mobile = $email_mobile;
        if ($model->sendEmail()) {
            return 'reset password successfully';
        }
        throw new BadRequestHttpException('Invalid data');
    }

    public function actionChangeEmail() {
        $user = Yii::$app->user->identity;
        $bodyParams = Yii::$app->request->bodyParams;
        $newEmail = $bodyParams['newEmail'];
        $password = $bodyParams['password'];

        $model = new ChangeEmailModel($user);
        $model->email = $newEmail;
        $model->password = $password;
        if ($model->changeEmail()) {
            return 'change email successfully';
        } else {
            if (isset($model->errors['email']))
                throw new BadRequestHttpException(null, self::CODE_INVALID_EMAIL);
            if (isset($model->errors['password']))
                throw new BadRequestHttpException(null, self::CODE_INCORRECT_PASSWORD);
        }
        throw new BadRequestHttpException('Invalid data');
    }

    public function actionActivateEmail() {
        $bodyParams = Yii::$app->request->bodyParams;
        $token = $bodyParams['token'];
        $userId = TokenHelper::authenticateToken($token, true, TokenHelper::TOKEN_ACTION_CHANGE_EMAIL);
        $user = User::findOne([
            'id' => $userId, 
            'status' => User::STATUS_WAIT_EMAIL,
        ]);
        if (!$user) throw new BadRequestHttpException('Invalid token');
        $user->status = User::STATUS_ACTIVE;
        UserToken::deleteAll([
            'user_id' => $user->id, 
            'action' => [TokenHelper::TOKEN_ACTION_CHANGE_EMAIL, TokenHelper::TOKEN_ACTION_ACCESS],
        ]);
        if ($user->save()) {
            return 'activate email successfully';
        }
        throw new BadRequestHttpException('Cannot activate email');       
    }

    public function actionProfile() {
        $user = Yii::$app->user->identity;
        return [
            'fullname' => $user->fullname,
            'email' => $user->email,
            'mobile' => $user->mobile,
        ];
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