<?php

use kartik\daterange\DateRangePicker;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $plants array */
/* @var $users array */
/* @var $devices array */

$this->title = 'Оперативный журнал';
?>
<div class="content">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Создать запись', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php echo $this->render('_search', ['model' => $searchModel,
        'devices' => $devices]); ?>

    <?
    $gridColumns = [
        [   // Date
            'attribute'=>'date',
            'width' => '170px',
            'headerOptions' => ['style' => 'text-align:center'],
            'contentOptions'=>['style' => 'color: #34515e'],
            'vAlign' => 'middle',
            'filter' => DateRangePicker::widget([
                'model' => $searchModel,
                'attribute' => 'date',
                'convertFormat'=>true,
                'includeMonthsFilter'=>true,
                'language' => 'ru-RU',
                'pluginEvents' => [
                    'cancel.daterangepicker' => 'function() { $(this).val(\'\').focus().attr("placeholder", "Нажмите Enter"); }',
                ],
                'pluginOptions' => [
                    'timePicker'=>true,
                     'timePicker24Hour' => true,
                    'locale' => [
                        'format'=>'Y-m-d H:i',
                        'separator' => ' -- ',
                        'cancelLabel'=> 'Clear',
                    ]
                ],
                'options' => ['placeholder' => 'Выберите диапазон...', 'class'=>'form-control']
            ]),
        ],
        [   // Date_Event
            'attribute'=>'date_event',
            'width' => '170px',
            'headerOptions' => ['style' => 'text-align:center'],
            'vAlign' => 'middle',
            'filter' => DateRangePicker::widget([
                'model' => $searchModel,
                'attribute' => 'date_event',
                'convertFormat'=>true,
                'includeMonthsFilter'=>true,
                'language' => 'ru-RU',
                'pluginEvents' => [
                    'cancel.daterangepicker' => 'function() { $(this).val(\'\').focus().attr("placeholder", "Нажмите Enter"); }',
                ],
                'pluginOptions' => [
                    'timePicker'=>true,
                    'timePicker24Hour' => true,
                    'locale' => [
                        'format'=>'Y-m-d H:i',
                        'separator' => ' -- ',
                        'cancelLabel'=> 'Clear',
                    ]
                ],
                'options' => ['placeholder' => 'Выберите диапазон...', 'class'=>'form-control']
            ]),
        ],
        [   // Changed
            'class' => '\kartik\grid\BooleanColumn',
            'attribute'=>'changed',
            'contentOptions' => ['class' => 'skip-export'], // Skip column when export
            'headerOptions' => ['class' => 'skip-export'], // Skip column when export
            'width' => '50px',
            'vAlign' => 'middle',
            'trueLabel' => 'Ред',
            'falseLabel' => '-',
            'falseIcon' => '<i class="fa fa-file-o fa-lg" aria-hidden="true"></i>',
            'trueIcon' => '<i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i>',
        ],
        [   // Plant
            'attribute'=>'plant_id',
            'width' => '100px',
            'headerOptions' => ['style' => 'text-align:center'],
            'vAlign' => 'middle',
            'content'=>function($data){
                return $data->getPlantName();
            },
            'filter' => $plants,
        ],
        [   // User
            'attribute'=>'user_id',
            'width' => '10%',
            'headerOptions' => ['style' => 'text-align:center'],
            'vAlign' => 'middle',
            'content'=>function($data){
                return $data->getUserShortName();
            },
            'filter' => $users,
        ],
        [
            // Text
            'attribute'=>'text',
            'headerOptions' => ['style' => 'text-align:center'],
            'vAlign' => 'middle',
        ],
        [
            // Comment
            'attribute'=>'comment',
            'headerOptions' => ['style' => 'text-align:center'],
            'vAlign' => 'middle',
        ],

        [   // Actions Button
            'class' => 'yii\grid\ActionColumn',
            'header'=>'',
            'contentOptions' => ['style' => 'text-align:center'],
            'template' => '{view} {update}',
        ],
    ];

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,

        'responsive'=>true,
        'hover'=>true,
        'containerOptions' => ['style' => 'overflow: auto'],
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],

        'toolbar' =>  [
            [
                'content' => Html::a('Сброс',['record/index'], ['class'=>'btn btn-md btn-danger'])
            ],
            '{export}',
            '{toggleData}',
        ],
        'export' => [
            'fontAwesome' => true,
            'showConfirmAlert' => false,
        ],
        'exportConfig' => [
            GridView::EXCEL => [
                'filename' => 'Оперативный журнал' . '_' . date("Y-m-d"),
                'config' => [
                    'worksheet' => 'Оперативный журнал',
                    'cssFile' => ''
                ],
            ],
        ],

        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        'persistResize' => false,
        'toggleDataOptions' => ['minCount' => 10,],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
        ],
    ]);
    ?>
</div>
