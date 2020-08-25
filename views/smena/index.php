<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\Smena */
/* @var $usersName array */
/* @var $smenaEvents array */

use app\assets\SmenaAsset;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Смена';
SmenaAsset::register($this);
?>

<div class="content">
    <div class="col-xs-3">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>Персонал в смене:</p>

        <?php $form = ActiveForm::begin([
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ],
        ]); ?>


            <?= $form->field($model, 'usersInSmena')->textInput([])->label(false)->widget(Select2::class, [
                'data' => $usersName,
                'size' => Select2::MEDIUM,
                'options' => [
                    'placeholder' => 'Выберите персонал в смене...',
                    'multiple' => true,
                    'autocomplete' => 'off',
                ],
                'pluginOptions' => ['allowClear' => true],
            ]);
            ?>


        <?= $form->field($model, 'comment')->textarea(['rows' => 6, 'placeholder' => 'Комментарий', 'class' => 'smena-comment']) ?>

        <div class="form-group">
            <div class="col-lg-12">
                <?=Html::a('Принять', '/smena/take-smena', ['data-method' => 'POST', 'class'=>'btn btn-primary']); ?>
                <?=Html::a('Сдать', '/smena/give-smena', ['data-method' => 'POST', 'class'=>'btn btn-danger']); ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <div class="col-xs-9">
        <div id="smena-events" data-smena-events="<?= Html::encode($smenaEvents) ?>"></div>
        <div id='calendar'></div>
    </div>
</div>