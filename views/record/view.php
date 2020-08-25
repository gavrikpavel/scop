<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Record */
/* @var $changedRecords array */

$this->title = 'Просмотр записи';
\yii\web\YiiAsset::register($this);
Yii::$app->formatter->locale = 'ru-RU';
?>
<div class="content">
    <div class="container">
        <div class="row record-view">
            <div class="topbutton">
                <?= Html::a('Вернуться к журналу', ['record/index'], ['class' => 'profile-link btn btn-primary']) ?>
            </div>

            <div class="col-xs-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <span class="panel-title">
                            <i class="fa fa-calendar-o" aria-hidden="true"></i>
                            <?= (Html::encode($model->date)) ?>
                        </span>
                        <span class="panel-title pull-right">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <?= (Html::encode($model->getUserShortName())) ?>
                        </span>
                    </div>
                    <p class="view-comment-label">
                        <?= (Html::encode($model->getAttributeLabel('text'))) ?>
                    </p>
                    <div class="panel-body">
                        <span class="view-text"><?= (Html::encode($model->text)) ?></span>
                    </div>
                    <p class="view-comment-label">
                        <?= (Html::encode($model->getAttributeLabel('comment'))) ?>
                    </p>
                    <div class="panel-body">
                        <span class="view-text"><?= (Html::encode($model->comment)) ?></span>
                    </div>
                    <div class="panel-footer">
                        <span>Переключение</span>
                        <span class="label label-success view-label"><?= (Html::encode($model->getDeviceShortName())) ?></span>
                        <span>произведено</span>
                        <span class="label label-success view-label"><?= (Html::encode($model->date_event)) ?></span>
                        <span> на </span>
                        <span class="label label-success view-label"><?= (Html::encode($model->getPlantName())) ?></span>
                    </div>
                </div>
            </div>
        </div>
        <!--Changed Records-->
        <div class="row record-view">
            <div class="col-xs-6">
                <?php foreach ($changedRecords as $changedRecord): ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span class="panel-title">
                                <i class="fa fa-calendar-o" aria-hidden="true"></i>
                                Изменено
                                <?= (Html::encode($changedRecord->date_changed)) ?>
                            </span>
                                <span class="panel-title pull-right">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <?= (Html::encode($changedRecord->getUserShortName())) ?>
                            </span>
                        </div>
                        <p class="view-comment-label">
                            <?= (Html::encode($changedRecord->getAttributeLabel('text'))) ?>
                        </p>
                        <div class="panel-body">
                            <span class="view-text"><?= (Html::encode($changedRecord->text)) ?></span>
                        </div>
                        <p class="view-comment-label">
                            <?= (Html::encode($changedRecord->getAttributeLabel('comment'))) ?>
                        </p>
                        <div class="panel-body">
                            <span class="view-text"><?= (Html::encode($changedRecord->comment)) ?></span>
                        </div>
                        <div class="panel-footer">
                            <span>Переключение</span>
                            <span class="label label-success view-label"><?= (Html::encode($changedRecord->getDeviceShortName())) ?></span>
                            <span>произведено</span>
                            <span class="label label-success view-label"><?= (Html::encode($changedRecord->date_event)) ?></span>
                            <span> на </span>
                            <span class="label label-success view-label"><?= (Html::encode($changedRecord->getPlantName())) ?></span>
                        </div>
                        <span class="label label-default view-label">
                            Создано
                            <?= (Html::encode($changedRecord->date)) ?>
                        </span>
                    </div>
                <br>
                <br>
                <br>
                <?php endforeach ?>
            <div>
        </div>
    </div>
</div>
