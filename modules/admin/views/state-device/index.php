<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StateDeviceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'State Devices';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="state-device-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create State Device', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'state_0',
            'state_1',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
