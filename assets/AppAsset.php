<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
    ];
    public $js = [
        'js/app.js',
    ];
    public $depends = [
        'app\assets\FontAwesomeAsset',
        'app\assets\SweetAlertAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapAsset',
        'app\assets\ControlAsset',
    ];
}