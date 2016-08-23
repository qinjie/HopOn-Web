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
            if ($user->save()) {
                return $user;
            }
        }
        return null;
    }
}
