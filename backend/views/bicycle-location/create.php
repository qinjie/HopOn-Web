<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\BicycleLocation */

$this->title = 'Create Bicycle Location';
$this->params['breadcrumbs'][] = ['label' => 'Bicycle Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bicycle-location-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
