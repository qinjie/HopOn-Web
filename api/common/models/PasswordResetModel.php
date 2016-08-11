<?php
namespace api\common\models;

use api\common\models\User;
use api\common\models\UserToken;
use api\common\helpers\TokenHelper;
use Yii;
use yii\base\Model;


class PasswordResetModel extends Model
{
    public $email_mobile;


    public function rules()
    {
        return [
            ['email_mobile', 'filter', 'filter' => 'trim'],
            ['email_mobile', 'required'],
        ];
    }

    public function sendEmail()
    {
        $user = User::find()
            ->where([
                'and',
                ['or', ['email' => $this->email_mobile], ['mobile' => $this->email_mobile]],
                ['status' => User::STATUS_ACTIVE],
            ])
            ->one();

        if (!$user) {
            return false;
        }
        UserToken::removeResetPasswordToken($user->id);
        $token = TokenHelper::createUserToken($user->id, TokenHelper::TOKEN_ACTION_RESET_PASSWORD);

        Yii::$app
            ->mailer
            ->compose(
                ['html' => '@common/mail/passwordResetToken-html'],
                [
                    'user' => $user,
                    'token' => $token->token,
                ]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($user->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();
        return $user;
    }
}
