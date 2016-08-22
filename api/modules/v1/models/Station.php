<?php

namespace api\modules\v1\models;

use api\common\models\User;
use api\modules\v1\models\Venue;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class Station extends ActiveRecord
{
 
    public static function tableName()
    {
        return 'station';
    }

    public function rules()
    {
        return [
            ['beacon_id', 'required'],
            [['beacon_id', 'bicycle_count'], 'integer'],

            [['latitude', 'longitude'], 'double'],

            [['name', 'address', 'postal'], 'required'],
            ['name', 'string', 'max' => 20],
            ['address', 'string', 'max' => 120],
            ['postal', 'string', 'max' => 10],

            [['updated_at', 'created_at'], 'safe'],
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
