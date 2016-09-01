<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "rental".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $bicycle_id
 * @property string $serial
 * @property string $book_at
 * @property string $pickup_at
 * @property string $return_at
 * @property integer $return_station_id
 * @property integer $duration
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 * @property Bicycle $bicycle
 */
class Rental extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rental';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                // Modify only created not updated attribute
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'bicycle_id', 'serial', 'book_at', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'bicycle_id', 'return_station_id', 'duration', 'created_at', 'updated_at'], 'integer'],
            [['book_at', 'pickup_at', 'return_at'], 'safe'],
            [['serial'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['bicycle_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bicycle::className(), 'targetAttribute' => ['bicycle_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'bicycle_id' => 'Bicycle ID',
            'serial' => 'Serial',
            'book_at' => 'Book At',
            'pickup_at' => 'Pickup At',
            'return_at' => 'Return At',
            'return_station_id' => 'Return Station ID',
            'duration' => 'Duration',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBicycle()
    {
        return $this->hasOne(Bicycle::className(), ['id' => 'bicycle_id']);
    }
}
