<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "feedback".
 *
 * @property integer $id
 * @property integer $rental_id
 * @property string $issue
 * @property string $comment
 * @property integer $rating
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Rental $rental
 */
class Feedback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feedback';
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
            [['rental_id', 'comment', 'rating'], 'required'],
            [['rental_id', 'rating', 'created_at', 'updated_at'], 'integer'],
            [['issue'], 'string', 'max' => 100],
            [['comment'], 'string', 'max' => 1000],
            [['rental_id'], 'unique'],
            [['rental_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rental::className(), 'targetAttribute' => ['rental_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rental_id' => 'Rental ID',
            'issue' => 'Issue',
            'comment' => 'Comment',
            'rating' => 'Rating',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRental()
    {
        return $this->hasOne(Rental::className(), ['id' => 'rental_id']);
    }
}
