<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Bicycle */

$this->title = 'Update Bicycle: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bicycles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bicycle-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
