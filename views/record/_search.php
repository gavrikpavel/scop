<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RecordSearch */
/* @var $form yii\widgets\ActiveForm */
/* @var $devices array */
?>

<div class="record-search">
    <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
    ]); ?>
    <br>
    <div class="input-form">
        <?= $form->field($model, 'device_id')->textInput([])->label(false)->widget(Select2::class, [
                'data' => $devices,
                'size' => Select2::MEDIUM,
                'options' => [
                    'placeholder' => 'Фильтр по оборудованию...',
                    'multiple' => true,
                    'autocomplete' => 'off',
                    ],
                'pluginOptions' => ['allowClear' => true],
                'addon' => [
                   'append' => [
                        'content' => Html::submitButton('<i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', [
                            'class' => 'btn btn-primary',
                        ]),
                       'asButton' => true
                    ]
                ]
            ]);
        ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
