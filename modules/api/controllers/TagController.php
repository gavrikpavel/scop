<?php

namespace app\modules\api\controllers;

use app\models\Device;
use app\models\Tag;
use app\models\TagLog;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\rest\Controller;

/**
 * Class TagController
 * API для работы с сервисом ServManGo
 * @package app\modules\api\controllers
 */
class TagController extends Controller
{
    /**
     * Возвращает данные АСУ тегов
     * @return array
     */
    public function actionView()
    {
        $dcsDevices = Device::findAll([
            'state_id' => [6, 7, 8, 10]
        ]);

        return ArrayHelper::toArray(Tag::findall([]), [
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
        $tagLog = new TagLog();

        $data = Json::decode(Yii::$app->request->getRawBody());
        $tag = Tag::findOne($id);
        $tag->value = $data['Value'];
        $tag->save();

        $prepData = [
            'id' => $tag->id,
            'value' => $tag->value
        ];
        $tagLog->saveLog($prepData);

        return true;
    }
}
