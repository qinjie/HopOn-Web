<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $fullname
 * @property string $auth_key
 * @property string $password_hash
 * @property string $email
 * @property string $mobile
 * @property integer $status
 * @property integer $role
 * @property string $name
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property BicycleLocation[] $bicycleLocations
 * @property Rental[] $rentals
 * @property UserToken[] $userTokens
 */
class UserModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fullname', 'auth_key', 'password_hash', 'email'], 'required'],
            [['status', 'role', 'created_at', 'updated_at'], 'integer'],
            [['fullname', 'password_hash', 'email', 'name'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['mobile'], 'string', 'max' => 16],
            [['email'], 'unique'],
            [['mobile'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fullname' => 'Fullname',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'email' => 'Email',
            'mobile' => 'Mobile',
            'status' => 'Status',
            'role' => 'Role',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBicycleLocations()
    {
        return $this->hasMany(BicycleLocation::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRentals()
    {
        return $this->hasMany(Rental::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTokens()
    {
        return $this->hasMany(UserToken::className(), ['user_id' => 'id']);
    }
}
