<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Авторизация';
?>
<div class="content">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Введите Ваши данные для регистрации в системе:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>



    <br>
    <style type="text/css">
        TABLE {
            border: 1px solid #8e8e8e; /* Рамка вокруг таблицы */
        }
        TD, TH {
            border: 1px solid #ccdae1; /* Рамка вокруг ячеек */
        }
    </style>

    <span style="color:#515151; font-size: 25px;">
        Вы можете зайти в систему используя следующие данные:
    </span>
    <span style="color:#515151; font-size: 25px;">Username:</span>
    <span style="color:#0088a3; font-size: 30px;">kip1     </span>
    <span style="color:#515151; font-size: 25px;">Password:</span>
    <span style="color:#0088a3; font-size: 30px;">123</span>
    <div class="panel panel-info">
        <div class="panel-heading">Группы доступа</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Группа</th>
                    <th>Логин</th>
                    <th>Пароль</th>
                    <th>Разрешения</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Гость</td>
                    <td>не требуется</td>
                    <td>не требуется</td>
                    <td>Просмотр Схемы</td>
                </tr>
                <tr>
                    <td>Оператор</td>
                    <td>kip1 (Иванов)</td>
                    <td>123</td>
                    <td>Заполнение Журнала, просмотр и выполнение переключений на Схеме, прием и сдача Смены</td>
                </tr>
                <tr>
                    <td>Инженер</td>
                    <td>eng</td>
                    <td>123</td>
                    <td>Просмотр Журнала, Схемы, Смены</td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
