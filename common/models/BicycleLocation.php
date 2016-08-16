<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bicycle_location".
 *
 * @property integer $id
 * @property integer $bicycle_id
 * @property double $latitude
 * @property double $longitude
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Bicycle $bicycle
 * @property User $user
 */
class BicycleLocation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bicycle_location';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bicycle_id', 'latitude', 'longitude', 'created_at', 'updated_at'], 'required'],
            [['bicycle_id', 'user_id', 'created_at', 'updated_at'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['bicycle_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bicycle::className(), 'targetAttribute' => ['bicycle_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bicycle_id' => 'Bicycle ID',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBicycle()
    {
        return $this->hasOne(Bicycle::className(), ['id' => 'bicycle_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
