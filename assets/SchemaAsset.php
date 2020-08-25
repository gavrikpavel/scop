<?php

namespace app\assets;

use yii\web\AssetBundle;

class SchemaAsset extends AssetBundle // Подключение на views/schema
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'js/schema.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'app\assets\ControlAsset',
    ];
}