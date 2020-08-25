<?php

namespace app\assets;

use yii\web\AssetBundle;

class SmenaAsset extends AssetBundle // Подключение на views/smena
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/smena.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'app\assets\CalendarAsset',
    ];
}