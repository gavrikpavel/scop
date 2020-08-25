<?php

namespace app\assets;

use yii\web\AssetBundle;

class CalendarAsset extends AssetBundle
{
    public $sourcePath = '@bower/fullcalendar';
    public $css = [
        'core/main.min.css',
        'daygrid/main.min.css',
    ];
    public $js = [
        'core/main.min.js',
        'daygrid/main.min.js',
    ];

    public $publishOptions = [
        'only' => [
            'core/*',
            'daygrid/*',
        ]
    ];

}
