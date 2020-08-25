<?php

namespace app\modules\api\controllers;

use app\models\Device;
use app\models\Log;
use app\models\Record;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\rest\Controller;

/**
 * Class DeviceController
 * API для работы с сервисом ServManGo
 * @package app\modules\api\controllers
 */
class DeviceController extends Controller
{
    /**
     * Возвращает данные АСУ устройств
     * @return array
     */
    public function actionView()
    {
        return ArrayHelper::toArray(Device::findall(['state_id' => [6, 7, 8]]), [
            'app\models\Device' => [
                'ID' => 'id',
                'Value' => 'value',
            ],
        ]);
    }

    /**
     * @param $id
     * @return bool
     */
    public function actionUpdate($id)
    {
        $log = new Log();
        $record = new Record();

        $data = Json::decode(Yii::$app->request->getRawBody());
        $device = Device::findOne($id);
        $device->value = $data['Value'];
        $device->save();

        $prepData = [
            'id' => $device->id,
            'command' => $device->value
        ];
        $log->saveLog($prepData);
        $record->saveRecordDCS($device->id);

        return true;
    }
}

//        слежение за процессом
//
//        exec("tasklist 2>NUL", $task_list);
//        print_r($task_list);
//        die();
