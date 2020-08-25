<?php

namespace app\controllers;

use app\models\Device;
use app\models\Log;
use app\models\Placard;
use app\models\PlacardDevice;
use app\models\Plant;
use app\models\Record;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;

/**
 * Class SchemaController
 * @package app\controllers
 */
class SchemaController extends Controller
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Переключение устройства
     * @return string
     */
    public function actionSetDevice()
    {
        if (Yii::$app->user->can('operator')) {
            $log = new Log();
            $record = new Record();

            $data = Json::decode(Yii::$app->request->getRawBody());
            $data['comment'] = htmlspecialchars($data['comment']);
            $data['dateTimeEvent'] = htmlspecialchars($data['dateTimeEvent']);

            if (is_int($data['id']) & is_int($data['command'])) {
                $log->saveLog($data);

                $device = Device::findOne($data['id']);
                $device->value = $data['command'];
                $device->save();
                $record->saveRecord($data);
                $sendData = array('id' => $device->id, 'value' => $device->value);
            }
            else {
                return false;
            }
            return JSON::encode($sendData);
        }
        return false;
    }

    /**
     * Получить РУ
     * @return string
     */
    public function actionArea()
    {
    $plants = ArrayHelper::toArray(Plant::find()->all(), [
        'app\models\Plant' => [
            'name' => 'name',
            'area' => 'area_viewbox',
        ],
    ]);
    return JSON::encode($plants);
    }

    /**
     * Получить все плакаты
     * @return string
     */
    public function actionPlacard()
    {
        $placards = ArrayHelper::toArray(Placard::find()->all(), [
            'app\models\Placard' => [
                'id' => 'id',
                'name' => 'name',
                'image' => 'path',
            ],
        ]);
        return JSON::encode($placards);
    }

    /**
     * Добавить плакат устройству
     * @return string
     */
    public function actionAddPlacard()
    {
        if (Yii::$app->user->can('operator')) {
            $record = new Record();
            $placardDevice = new PlacardDevice();

            $data = Json::decode(Yii::$app->request->getRawBody());
            $data['dateTimeEvent'] = htmlspecialchars($data['dateTimeEvent']);

            if (is_int($data['deviceId']) & is_int($data['placardId'])) {
                $placardDevice->savePlacardDevice($data);

                //$record->saveRecordPlacard($data, 'Установлен плакат');
                $sendData = ArrayHelper::toArray(Placard::findOne($data['placardId']), [
                    'app\models\Placard' => [
                        'id' => 'id',
                        'name' => 'name',
                        'image' => 'path',
                    ],
                ]);
            }
            else {
                return false;
            }
            return JSON::encode($sendData);
        }
        return false;
    }

    /**
     * Удалить плакат из устройства
     * @return bool|string
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeletePlacard()
    {
        if (Yii::$app->user->can('operator')) {
            $record = new Record();

            $data = Json::decode(Yii::$app->request->getRawBody());
            $data['dateTimeEvent'] = htmlspecialchars($data['dateTimeEvent']);

            if (is_int($data['deviceId']) & is_int($data['placardId'])) {
                $device = Device::findOne($data['deviceId']);
                $offPlacard = PlacardDevice::find()->where([
                    'device_id' => $data['deviceId'],
                    'placard_id' => $data['placardId']
                ])->one();
                $offPlacard->delete();
                //$record->saveRecordPlacard($data, 'Снят плакат');

                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Получить значения устройств АСУ ТП
     * @return string
     */
    public function actionDcsDevicesValue()
    {
        $dcsDevices = ArrayHelper::toArray(Device::findall(['state_id' => [6, 7, 8]]), [
            'app\models\Device' => [
                'id' => 'id',
                'value' => 'value',
            ],
        ]);
        return JSON::encode($dcsDevices);
    }
}