<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Image */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="image-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'file')->widget(\kartik\file\FileInput::className(),
        [
            'options' => ['accept' => 'image/*'],
            'pluginOptions' => [
                'showUpload' => false,
//                'dropZoneTitle'=>'Drag & drop jpg, png, gif files here …',
//                'uploadUrl' => \yii\helpers\Url::to(['uploads/images', 'id'=>$model->id,]),
            ]
        ]
    ) ?>

    <?= $form->field($model, 'data')->textInput()->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'created_at')->textInput()->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'updated_at')->textInput()->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
