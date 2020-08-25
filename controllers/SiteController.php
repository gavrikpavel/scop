<?php

namespace app\controllers;

use app\models\Device;
use app\models\Tag;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;

/**
 * Class SiteController
 * @package app\controllers
 */
class SiteController extends Controller
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
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     * Переключение устройства
     * @return string
     */
    public function actionStateBdm()
    {
        $data = Json::decode(Yii::$app->request->getRawBody());

        if (is_int($data['id'])) {
            $tag = Tag::findOne($data['id']);
            $sendData = $tag->getMonthStateBdm(($data['month']));
        }
        else {
            return false;
        }
        return JSON::encode($sendData);
    }

    /**
     * @return string
     */
    public function actionSchema()
    {
        $switches = Device::findAll([
            'state_id' => '1',
        ]);
        $disconnectors = Device::findAll([
            'state_id' => '2',
        ]);
        $earthDisconnectors = Device::findAll([
            'state_id' => '3',
        ]);
        $hDisconnectors = Device::findAll([
            'state_id' => '4',
        ]);
        $loadDisconnectors = Device::findAll([
            'state_id' => '5',
        ]);
        $dcsSwitches = Device::findAll([
            'state_id' => '6',
        ]);
        $dcsSimpleSwitches = Device::findAll([
            'state_id' => '7',
        ]);
        $dcsEarthDisconnectors = Device::findAll([
            'state_id' => '8',
        ]);
        $secEarthDisconnectors = Device::findAll([
            'state_id' => '9',
        ]);
        $secDisconnectors = Device::findAll([
            'state_id' => '10',
        ]);


        // Отображение control-box для групп пользователей
        if (Yii::$app->user->can('operator') | Yii::$app->user->can('engineer')) {
            $permissionControl ='true';
        }
        else $permissionControl ='false';

        // Отображение кнопок управления в control-box только для Operator
        $viewControl =  Yii::$app->user->can('operator') ? 'true' : 'false';

        return $this->render('schema', [
            'switches' => $switches,
            'disconnectors' => $disconnectors,
            'earthDisconnectors' => $earthDisconnectors,
            'hDisconnectors' => $hDisconnectors,
            'loadDisconnectors' => $loadDisconnectors,
            'dcsSwitches' => $dcsSwitches,
            'dcsSimpleSwitches' => $dcsSimpleSwitches,
            'dcsEarthDisconnectors' => $dcsEarthDisconnectors,
            'secEarthDisconnectors' => $secEarthDisconnectors,
            'secDisconnectors' => $secDisconnectors,
            'permissionControl' => $permissionControl,
            'viewControl' => $viewControl,
        ]);
    }

    /**
     * @return string
     */
    public function actionHelp()
    {
        return $this->render('help');
    }
}