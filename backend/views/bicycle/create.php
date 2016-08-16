<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Bicycle */

$this->title = 'Create Bicycle';
$this->params['breadcrumbs'][] = ['label' => 'Bicycles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bicycle-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
