<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Beacon */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="beacon-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'uuid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'major')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'minor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput()->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'updated_at')->textInput()->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
