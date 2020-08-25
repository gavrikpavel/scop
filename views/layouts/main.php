<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'innerContainerOptions' => ['class' => 'container-fluid'],
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Главная', 'url' => ['/']],
            ['label' => 'Журнал', 'url' => ['/record/index']],
            ['label' => 'Схема', 'url' => ['/site/schema']],
            ['label' => ''],
            ['label' => 'Смена', 'url' => ['/smena/index'], 'options' => ['class' => 'personal-links']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Войти', 'url' => ['/auth/login'], 'options' => ['class' => 'personal-links']]
            ) : (
                '<li class="personal-links">'
                . Html::beginForm(['/auth/logout'], 'post')
                . Html::submitButton(
                    'Выйти (' . Yii::$app->user->identity->short_name . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            ),
            ['label' => '', 'url' => ['/site/help'], 'linkOptions' => ['class' => 'fa fa-question-circle fa-2x']],
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container-fluid">
        <?= $content ?>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
