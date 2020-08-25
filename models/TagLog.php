<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tag_log".
 *
 * @property int $id
 * @property int|null $device_id
 * @property int|null $value
 * @property string|null $date
 */
class TagLog extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['device_id', 'value'], 'integer'],
            [['date'], 'safe'],
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

    public function saveLog($data)
    {
        $this->device_id = $data['id'];
        $this->value = $data['value'];
        $this->date = date("Y-m-d H:i:s");
        $this->save();
    }
}
