<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">
    <h1>Ошибка доступа</h1>
    <h2 class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </h2>
</div>
