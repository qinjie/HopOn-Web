<?php
namespace api\common\models;

use api\common\models\User;
use api\common\models\UserToken;
use api\common\helpers\TokenHelper;

use Yii;
use yii\base\Model;


class ChangeEmailModel extends Model
{
    public $email;
    public $password;
    public $user;

    public function __construct($user, $config = [])
    {
        $this->user = $user;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'filter', 'filter' => 'trim'],
            ['password', 'validatePassword'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => 'api\common\models\User', 'message' => 'This email address has already been taken.'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        $user = $this->user;
        if (!$this->errors && !$user->validatePassword($this->password)) {
            $this->addError($attribute, 'Incorrect password.');
        }
    }

    public function changeEmail() {
        if ($this->validate()) {
            $user = $this->user;
            $user->email = $this->email;
            $user->status = User::STATUS_WAIT_EMAIL;
            if ($user->save()) {
                UserToken::deleteAll([
                    'user_id' => $user->id, 
                    'action' => [TokenHelper::TOKEN_ACTION_CHANGE_EMAIL, TokenHelper::TOKEN_ACTION_ACCESS],
                ]);
                $token = TokenHelper::createUserToken($user->id, TokenHelper::TOKEN_ACTION_CHANGE_EMAIL);
                # send activation email
                Yii::$app->mailer->compose(['html' => '@common/mail/emailChangeToken-html'], ['user' => $user, 'token' => $token->token])
                    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                    ->setTo($this->email)
                    ->setSubject('Email Address Changed')
                    ->send();

                return $user;
            }
        }
        return null;
    }
}
