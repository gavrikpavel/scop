<?php

namespace app\commands;

use app\jobs\SaveFileJob;
use Yii;
use yii\console\Controller;

/**
 * Class FileInfoController
 * Добавление в очередь заданий
 * @package app\commands
 */
class FileInfoController  extends Controller
{
    public function actionIndex()
    {
        Yii::$app->queue->push(new SaveFileJob([
            'filename' => 'E:/OSPanel/domains/scop/web' . '/file.txt',
            'data' => date("Y-m-d H:i:s"),
        ]));
    }
}