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
