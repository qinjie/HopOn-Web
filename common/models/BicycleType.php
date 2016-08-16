<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bicycle_type".
 *
 * @property integer $id
 * @property string $brand
 * @property string $model
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Bicycle[] $bicycles
 */
class BicycleType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bicycle_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['brand', 'model', 'created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['brand', 'model'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brand' => 'Brand',
            'model' => 'Model',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBicycles()
    {
        return $this->hasMany(Bicycle::className(), ['bicycle_type_id' => 'id']);
    }
}
