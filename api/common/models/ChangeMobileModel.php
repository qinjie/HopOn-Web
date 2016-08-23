<?php
namespace api\common\models;

use api\common\models\User;
use api\common\models\UserToken;
use api\common\helpers\TokenHelper;

use Yii;
use yii\base\Model;


class ChangeMobileModel extends Model
{
    public $mobile;
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
            [['mobile', 'password'], 'required'],
            ['mobile', 'filter', 'filter' => 'trim'],
            ['password', 'validatePassword'],
            ['mobile', 'string', 'min' => 8],
            ['mobile', 'unique', 'targetClass' => 'api\common\models\User', 'message' => 'This mobile phone has already been taken.'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        $user = $this->user;
        if (!$this->errors && !$user->validatePassword($this->password)) {
            $this->addError($attribute, 'Incorrect password.');
        }
    }

    public function changeMobile() {
        if ($this->validate()) {
            $user = $this->user;
            $user->mobile = $this->mobile;
            if ($user->save()) {
                return $user;
            }
        }
        return null;
    }
}
