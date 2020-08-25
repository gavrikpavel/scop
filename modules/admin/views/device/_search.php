<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DeviceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="device-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'plant_id') ?>

    <?= $form->field($model, 'location_id') ?>

    <?= $form->field($model, 'state_id') ?>

    <?= $form->field($model, 'short_name') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'kks') ?>

    <?php // echo $form->field($model, 'value') ?>

    <?php // echo $form->field($model, 'info') ?>

    <?php // echo $form->field($model, 'pos_x') ?>

    <?php // echo $form->field($model, 'pos_y') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>