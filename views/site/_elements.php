<?php

use yii\helpers\Html;

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
?>

<?php foreach($earthDisconnectors as $earthDisconnector):?>
    <?= Html::tag('earth-disconnector-el','',[
        'v-bind:id' => $earthDisconnector->id,
        'v-bind:pos-x' => $earthDisconnector->pos_x,
        'v-bind:pos-y' => $earthDisconnector->pos_y,
        'v-bind:in-value' => $earthDisconnector->value,
        'kks' => $earthDisconnector->kks,
        'short-name' => $earthDisconnector->short_name,
        'name' => $earthDisconnector->name,
        'color' => $earthDisconnector->getColorPlant(),
        'in-placards' => $earthDisconnector->getJsonPlacards(),
    ]); ?>
<?php endforeach; ?>

<?php foreach($disconnectors as $disconnector):?>
    <?= Html::tag('v-disconnector-el','',[
        'v-bind:id' => $disconnector->id ,
        'v-bind:pos-x' => $disconnector->pos_x,
        'v-bind:pos-y' => $disconnector->pos_y,
        'v-bind:in-value' => $disconnector->value,
        'kks' => $disconnector->kks,
        'short-name' => $disconnector->short_name,
        'name' => $disconnector->name,
        'color' => $disconnector->getColorPlant(),
        'in-placards' => $disconnector->getJsonPlacards(),
    ]); ?>
<?php endforeach; ?>

<?php foreach($hDisconnectors as $hDisconnectors):?>
    <?= Html::tag('h-disconnector-el','',[
        'v-bind:id' => $hDisconnectors->id ,
        'v-bind:pos-x' => $hDisconnectors->pos_x,
        'v-bind:pos-y' => $hDisconnectors->pos_y,
        'v-bind:in-value' => $hDisconnectors->value,
        'kks' => $hDisconnectors->kks,
        'short-name' => $hDisconnectors->short_name,
        'name' => $hDisconnectors->name,
        'color' => $hDisconnectors->getColorPlant(),
        'in-placards' => $hDisconnectors->getJsonPlacards(),
    ]); ?>
<?php endforeach; ?>

<?php foreach($secDisconnectors as $secDisconnector):?>
    <?= Html::tag('sec-disconnector-el','',[
        'v-bind:id' => $secDisconnector->id ,
        'v-bind:pos-x' => $secDisconnector->pos_x,
        'v-bind:pos-y' => $secDisconnector->pos_y,
        'v-bind:in-value' => $secDisconnector->value,
        'kks' => $secDisconnector->kks,
        'short-name' => $secDisconnector->short_name,
        'name' => $secDisconnector->name,
        'color' => $secDisconnector->getColorPlant(),
        'in-placards' => $secDisconnector->getJsonPlacards(),
    ]); ?>
<?php endforeach; ?>

<?php foreach($loadDisconnectors as $loadDisconnector):?>
    <?= Html::tag('l-disconnector-el','',[
        'v-bind:id' => $loadDisconnector->id ,
        'v-bind:pos-x' => $loadDisconnector->pos_x,
        'v-bind:pos-y' => $loadDisconnector->pos_y,
        'v-bind:in-value' => $loadDisconnector->value,
        'kks' => $loadDisconnector->kks,
        'short-name' => $loadDisconnector->short_name,
        'name' => $loadDisconnector->name,
        'color' => $loadDisconnector->getColorPlant(),
        'in-placards' => $loadDisconnector->getJsonPlacards(),
    ]); ?>
<?php endforeach; ?>

<?php foreach($dcsEarthDisconnectors as $dcsEarthDisconnector):?>
    <?= Html::tag('dcs-earth-disconnector-el','',[
        'v-bind:id' => $dcsEarthDisconnector->id,
        'v-bind:pos-x' => $dcsEarthDisconnector->pos_x,
        'v-bind:pos-y' => $dcsEarthDisconnector->pos_y,
        'v-bind:in-value' => $dcsEarthDisconnector->value,
        'kks' => $dcsEarthDisconnector->kks,
        'short-name' => $dcsEarthDisconnector->short_name,
        'name' => $dcsEarthDisconnector->name,
        'color' => $dcsEarthDisconnector->getColorPlant(),
        'in-placards' => $dcsEarthDisconnector->getJsonPlacards(),
    ]); ?>
<?php endforeach; ?>

<?php foreach($secEarthDisconnectors as $secEarthDisconnector):?>
    <?= Html::tag('sec-earth-disconnector-el','',[
        'v-bind:id' => $secEarthDisconnector->id,
        'v-bind:pos-x' => $secEarthDisconnector->pos_x,
        'v-bind:pos-y' => $secEarthDisconnector->pos_y,
        'v-bind:in-value' => $secEarthDisconnector->value,
        'kks' => $secEarthDisconnector->kks,
        'short-name' => $secEarthDisconnector->short_name,
        'name' => $secEarthDisconnector->name,
        'color' => $secEarthDisconnector->getColorPlant(),
        'in-placards' => $secEarthDisconnector->getJsonPlacards(),
    ]); ?>
<?php endforeach; ?>

<?php foreach($switches as $switch):?>
    <?= Html::tag('switch-el','',[
        'v-bind:id' => $switch->id,
        'v-bind:pos-x' => $switch->pos_x,
        'v-bind:pos-y' => $switch->pos_y,
        'v-bind:in-value' => $switch->value,
        'kks' => $switch->kks,
        'short-name' => $switch->short_name,
        'name' => $switch->name,
        'color' => $switch->getColorPlant(),
        'in-placards' => $switch->getJsonPlacards(),
    ]); ?>
<?php endforeach; ?>

<?php foreach($dcsSwitches as $dcsSwitch):?>
    <?= Html::tag('dcs-switch-el','',[
        'v-bind:id' => $dcsSwitch->id ,
        'v-bind:pos-x' => $dcsSwitch->pos_x,
        'v-bind:pos-y' => $dcsSwitch->pos_y,
        'v-bind:in-value' => $dcsSwitch->value,
        'kks' => $dcsSwitch->kks,
        'short-name' => $dcsSwitch->short_name,
        'name' => $dcsSwitch->name,
        'color' => $dcsSwitch->getColorPlant(),
        'in-placards' => $dcsSwitch->getJsonPlacards(),
    ]); ?>
<?php endforeach; ?>

<?php foreach($dcsSimpleSwitches as $dcsSimpleSwitch):?>
    <?= Html::tag('dcs-simple-switch-el','',[
        'v-bind:id' => $dcsSimpleSwitch->id ,
        'v-bind:pos-x' => $dcsSimpleSwitch->pos_x,
        'v-bind:pos-y' => $dcsSimpleSwitch->pos_y,
        'v-bind:in-value' => $dcsSimpleSwitch->value,
        'kks' => $dcsSimpleSwitch->kks,
        'short-name' => $dcsSimpleSwitch->short_name,
        'name' => $dcsSimpleSwitch->name,
        'color' => $dcsSimpleSwitch->getColorPlant(),
        'in-placards' => $dcsSimpleSwitch->getJsonPlacards(),
    ]); ?>
<?php endforeach; ?>


