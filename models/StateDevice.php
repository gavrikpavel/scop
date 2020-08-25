<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "state_device".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $state_0
 * @property string|null $state_1
 */
class StateDevice extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'state_device';
    }

    /**
     * @return array
     */
    public static function nameStateDevices()
    {
        return ArrayHelper::map(StateDevice::find()->all(), 'id', 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 100],
            [['state_0', 'state_1'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'state_0' => 'State 0',
            'state_1' => 'State 1',
        ];
    }
}
