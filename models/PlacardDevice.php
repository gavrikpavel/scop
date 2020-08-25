<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "placard_device".
 *
 * @property int $id
 * @property int|null $device_id
 * @property int|null $placard_id
 */
class PlacardDevice extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'placard_device';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['device_id', 'placard_id'], 'integer'],
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
            'placard_id' => 'Placard ID',
        ];
    }

    /**
     * @param $data
     * @return bool
     */
    public function savePlacardDevice($data)
    {
        $this->device_id = $data['deviceId'];
        $this->placard_id = $data['placardId'];
        $this->save();
    }
}
