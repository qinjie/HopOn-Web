<?php

namespace api\common\models;

use api\common\models\User;
use api\common\helpers\TokenHelper;
use yii\base\Model;
use Yii;

class SignupModel extends Model
{
    public $fullname;
    public $email;
    public $password;
    public $role;
    public $mobile;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['fullname', 'filter', 'filter' => 'trim'],
            ['fullname', 'required'],
            ['fullname', 'string', 'min' => 4, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => 'api\common\models\User', 'message' => 'This email address has already been taken.'],

            ['mobile', 'filter', 'filter' => 'trim'],
            ['mobile', 'required'],
            ['mobile', 'unique', 'targetClass' => 'api\common\models\User', 'message' => 'This mobile phone has already been taken.'],
            ['mobile', 'string', 'min' => 8],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->fullname = $this->fullname;
            $user->email = $this->email;
            $user->mobile = $this->mobile;
            $user->setPassword($this->password);
            $user->status = User::STATUS_WAIT_EMAIL;
            $user->role = $this->role;
            $user->name = User::$roles[$this->role];

            if ($user->save()) {
                $token = TokenHelper::createUserToken($user->id, TokenHelper::TOKEN_ACTION_ACTIVATE_ACCOUNT);
                # send activation email
                Yii::$app->mailer->compose(['html' => '@common/mail/emailConfirmToken-html'], ['user' => $user, 'token' => $token->token])
                    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                    ->setTo($this->email)
                    ->setSubject('Email confirmation for ' . Yii::$app->name)
                    ->send();

                return $user;
            }
        }

        return null;
    }
}
