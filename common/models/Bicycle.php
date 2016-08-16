<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bicycle".
 *
 * @property integer $id
 * @property string $serial
 * @property integer $bicycle_type_id
 * @property string $desc
 * @property integer $status
 * @property integer $station_id
 * @property integer $beacon_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Station $station
 * @property Beacon $beacon
 * @property BicycleType $bicycleType
 * @property BicycleLocation[] $bicycleLocations
 * @property Rental[] $rentals
 */
class Bicycle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bicycle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['serial', 'created_at', 'updated_at'], 'required'],
            [['bicycle_type_id', 'status', 'station_id', 'beacon_id', 'created_at', 'updated_at'], 'integer'],
            [['serial'], 'string', 'max' => 20],
            [['desc'], 'string', 'max' => 50],
            [['station_id'], 'exist', 'skipOnError' => true, 'targetClass' => Station::className(), 'targetAttribute' => ['station_id' => 'id']],
            [['beacon_id'], 'exist', 'skipOnError' => true, 'targetClass' => Beacon::className(), 'targetAttribute' => ['beacon_id' => 'id']],
            [['bicycle_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => BicycleType::className(), 'targetAttribute' => ['bicycle_type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'serial' => 'Serial',
            'bicycle_type_id' => 'Bicycle Type ID',
            'desc' => 'Desc',
            'status' => 'Status',
            'station_id' => 'Station ID',
            'beacon_id' => 'Beacon ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStation()
    {
        return $this->hasOne(Station::className(), ['id' => 'station_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBeacon()
    {
        return $this->hasOne(Beacon::className(), ['id' => 'beacon_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBicycleType()
    {
        return $this->hasOne(BicycleType::className(), ['id' => 'bicycle_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBicycleLocations()
    {
        return $this->hasMany(BicycleLocation::className(), ['bicycle_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRentals()
    {
        return $this->hasMany(Rental::className(), ['bicycle_id' => 'id']);
    }
}
