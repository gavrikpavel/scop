<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Device */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="device-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'plant_id')->dropDownList($plants) ?>
   
    <?= $form->field($model, 'location_id')->dropDownList($locations) ?>

    <?= $form->field($model, 'state_id')->dropDownList($typeDevice) ?>

    <?= $form->field($model, 'short_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kks')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'value')->textInput() ?>

    <?= $form->field($model, 'info')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pos_x')->textInput() ?>

    <?= $form->field($model, 'pos_y')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
