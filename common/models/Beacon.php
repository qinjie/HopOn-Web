<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "beacon".
 *
 * @property integer $id
 * @property string $uuid
 * @property string $major
 * @property string $minor
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Bicycle[] $bicycles
 * @property Station[] $stations
 */
class Beacon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'beacon';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uuid'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['uuid'], 'string', 'max' => 100],
            [['major', 'minor'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uuid' => 'Uuid',
            'major' => 'Major',
            'minor' => 'Minor',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBicycles()
    {
        return $this->hasMany(Bicycle::className(), ['beacon_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStations()
    {
        return $this->hasMany(Station::className(), ['beacon_id' => 'id']);
    }
}
