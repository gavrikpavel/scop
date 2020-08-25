<?php

namespace app\assets;

use yii\web\AssetBundle;

class SweetAlertAsset extends AssetBundle
{
    public $sourcePath = '@bower/sweetalert2';
    public $css = [
        'sweetalert2.min.css',
    ];
    public $js = [
        'sweetalert2.min.js',
    ];
}
