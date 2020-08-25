<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "log".
 *
 * @property int $id
 * @property int|null $device_id
 * @property int|null $value
 * @property string|null $date
 */
class Log extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['device_id', 'value', 'date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'device_id' => 'Device ID',
            'value' => 'Value',
            'date' => 'Date',
        ];
    }

    /**
     * @param $data
     * @return bool
     */
    public function saveLog($data)
    {
        $this->device_id = $data['id'];
        $this->value = $data['command'];
        $this->date = date("Y-m-d H:i:s");
        $this->save();
    }
}
