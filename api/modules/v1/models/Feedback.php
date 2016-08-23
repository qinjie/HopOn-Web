<?php

namespace api\modules\v1\models;

use api\common\models\User;
use api\modules\v1\models\Venue;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class Feedback extends ActiveRecord
{
    const ISSUE_OTHERS = 0;
    const ISSUE_BREAK_NOT_EFFECTIVE = 1;
    const ISSUE_TYRE_FLAT = 2;
    const ISSUE_CHAIN_GEARS_FAULTY = 3;
    const ISSUE_PARTS_LOOSE = 4;

    public static function tableName()
    {
        return 'feedback';
    }

    public function rules()
    {
        return [
            ['rental_id', 'required'],
            ['rental_id', 'integer'],

            ['issue', 'integer'],
            ['issue', 'default', 'value' => self::ISSUE_OTHERS],
            ['issue', 'in', 'range' => array_keys(self::getIssuesArray())],

            ['comment', 'required'],
            ['comment', 'string', 'max' => 1000],

            ['rating', 'required'],
            ['rating', 'double'],
            ['rating', 'in', 'range' => [0, 1, 2, 3, 4, 5]],

            [['updated_at', 'created_at'], 'safe'],
        ];
    }

    public static function getIssuesArray()
    {
        return [
            self::ISSUE_OTHERS => 'Others',
            self::ISSUE_BREAK_NOT_EFFECTIVE => 'Break not effective',
            self::ISSUE_TYRE_FLAT => 'Tyre(s) flat',
            self::ISSUE_CHAIN_GEARS_FAULTY => 'Chain, gears faulty',
            self::ISSUE_PARTS_LOOSE => 'Parts loose/dented/scratched, e.g. basket',
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
