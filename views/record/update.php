<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Record */
/* @var $plants array */
/* @var $devices array */
/* @var $currentUser string */

$this->title = 'Обновить запись'
?>
<div class="content">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'plants' => $plants,
        'devices' => $devices,
        'currentUser' => $currentUser,
    ]) ?>
</div>
