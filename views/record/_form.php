<?php

use kartik\daterange\DateRangePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Record */
/* @var $form yii\widgets\ActiveForm */
/* @var $plants array */
/* @var $devices array */
/* @var $currentUser string */

?>

<div class="row">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-xs-3">
        <?= $form->field($model, 'plant_id')->widget(Select2::class, [
            'data' => $plants,
            'options' => ['placeholder' => 'Выберите РУ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>
    </div>

    <div class="col-xs-3">
        <?= $form->field($model, 'device_id')->widget(Select2::class, [
            'data' => $devices,
            'options' => ['placeholder' => 'Выберите Оборудование...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>
    </div>

    <div class="col-xs-3">
        <?= $form->field($model, 'date_event')->widget(DateRangePicker::class, [
            'convertFormat'=>true,
            'includeMonthsFilter'=>true,
            'language' => 'ru-RU',
            'options' => [
                'placeholder' => 'Выберите дату и время события...',
                'autocomplete' => 'off',
            ],
            'pluginOptions' => [
                'showDropdowns'=>true,
                'singleDatePicker'=>true,
                'timePicker'=>true,
                'timePicker24Hour' => true,
                'locale' => [
                    'format'=>'Y-m-d H:i',
                ]
            ],
        ]) ?>
    </div>

    <div class="col-xs-9">
        <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>
    </div>
    <div class="col-xs-9">
        <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>
    </div>

    <div class="form-group col-xs-7">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-lg']) ?>
        <a class="btn btn-primary btn-lg" href="/record/index">Отменить</a>
    </div>
    <div class="col-xs-2 label-user">
        <span>
            <i class="fa fa-user" aria-hidden="true"></i>
            <?= $currentUser ?>
        </span>
    </div>

    <?php ActiveForm::end(); ?>

</div>
