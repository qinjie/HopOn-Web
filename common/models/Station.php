<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "station".
 *
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property string $postal
 * @property double $latitude
 * @property double $longitude
 * @property integer $beacon_id
 * @property integer $bicycle_count
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Bicycle[] $bicycles
 * @property Beacon $beacon
 */
class Station extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'station';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'address', 'postal', 'bicycle_count', 'created_at', 'updated_at'], 'required'],
            [['latitude', 'longitude'], 'number'],
            [['beacon_id', 'bicycle_count', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 20],
            [['address'], 'string', 'max' => 120],
            [['postal'], 'string', 'max' => 10],
            [['beacon_id'], 'exist', 'skipOnError' => true, 'targetClass' => Beacon::className(), 'targetAttribute' => ['beacon_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'address' => 'Address',
            'postal' => 'Postal',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'beacon_id' => 'Beacon ID',
            'bicycle_count' => 'Bicycle Count',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBicycles()
    {
        return $this->hasMany(Bicycle::className(), ['station_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBeacon()
    {
        return $this->hasOne(Beacon::className(), ['id' => 'beacon_id']);
    }
}
