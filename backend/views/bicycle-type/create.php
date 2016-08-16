<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\BicycleType */

$this->title = 'Create Bicycle Type';
$this->params['breadcrumbs'][] = ['label' => 'Bicycle Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bicycle-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
