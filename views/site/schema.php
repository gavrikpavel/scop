<?php

use app\assets\SchemaAsset;

/* @var $this yii\web\View */
/* @var $switches app\models\Device */
/* @var $disconnectors app\models\Device */
/* @var $earthDisconnectors app\models\Device */
/* @var $hDisconnectors app\models\Device */
/* @var $loadDisconnectors app\models\Device */
/* @var $dcsSwitches app\models\Device */
/* @var $dcsSimpleSwitches app\models\Device */
/* @var $dcsEarthDisconnectors app\models\Device */
/* @var $secEarthDisconnectors app\models\Device */
/* @var $secDisconnectors app\models\Device */
/* @var $permissionControl string */
/* @var $viewControl string */


$this->title = 'Схема';
SchemaAsset::register($this);
?>

<div id="app">
    <scale-box></scale-box>
    <field-box></field-box>
    <?= $this->render('_svg_schema', [
        'switches' => $switches,
        'disconnectors' => $disconnectors,
        'earthDisconnectors' => $earthDisconnectors,
        'hDisconnectors' => $hDisconnectors,
        'loadDisconnectors' => $loadDisconnectors,
        'dcsSwitches' => $dcsSwitches,
        'dcsSimpleSwitches' => $dcsSimpleSwitches,
        'dcsEarthDisconnectors' => $dcsEarthDisconnectors,
        'secEarthDisconnectors' => $secEarthDisconnectors,
        'secDisconnectors' => $secDisconnectors,
    ]) ?>
    <control-box
        v-bind:view-control= <?= $viewControl ?>
        v-if= <?= $permissionControl ?>
    ></control-box>
</div>

