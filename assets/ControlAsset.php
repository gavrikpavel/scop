<?php

namespace app\assets;

use yii\web\AssetBundle;

class ControlAsset extends AssetBundle
{
    public $sourcePath = '@bower';
    public $js = [
        'screenfull/dist/screenfull.min.js',
        'axios/dist/axios.js',
        'vue/dist/vue.js',
    ];

    public $publishOptions = [
        'only' => [
            'screenfull/dist/*',
            'axios/dist/*',
            'vue/dist/*',
        ]
    ];
}
