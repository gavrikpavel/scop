<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StateDevice */

$this->title = 'Update State Device: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'State Devices', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="state-device-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
