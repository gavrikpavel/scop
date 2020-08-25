<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StateDevice */

$this->title = 'Create State Device';
$this->params['breadcrumbs'][] = ['label' => 'State Devices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="state-device-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
