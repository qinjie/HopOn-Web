<?php

namespace api\modules\v1\models;

use api\common\models\User;
use api\modules\v1\models\Venue;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class Bicycle extends ActiveRecord
{
    const STATUS_FREE = 0;
    const STATUS_LOCKED = 1;
    const STATUS_UNLOCKED = 2;
    const STATUS_MAINTENANCE = 3;
    const STATUS_BOOKED = 4;

    public static function tableName()
    {
        return 'bicycle';
    }

    public function rules()
    {
        return [
            ['bicycle_type_id', 'required'],
            ['bicycle_type_id', 'integer'],

            [['desc'], 'string', 'max' => 50],

            ['status', 'integer'],
            ['status', 'default', 'value' => self::STATUS_FREE],
            ['status', 'in', 'range' => array_keys(self::getStatusesArray())],

            [['station_id', 'beacon_id'], 'required'],
            [['station_id', 'beacon_id'], 'integer'],

            [['updated_at', 'created_at'], 'safe'],
        ];
    }

    public static function getStatusesArray()
    {
        return [
            self::STATUS_FREE => 'Free',
            self::STATUS_MAINTENANCE => 'Maintenance',
            self::STATUS_LOCKED => 'Locked',
            self::STATUS_UNLOCKED => 'Unlocked',
            self::STATUS_BOOKED => 'Booked'
        ];
    }

    public function fields() {
        $fields = parent::fields();
        unset($fields['created_at'], $fields['updated_at']);
        return $fields;
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => time(),
            ],
        ];
    }
}
