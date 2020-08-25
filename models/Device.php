<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * This is the model class for table "device".
 *
 * @property int $id
 * @property int $plant_id
 * @property int|null $location_id
 * @property int|null $state_id
 * @property string|null $short_name
 * @property string $name
 * @property string|null $kks
 * @property int|null $value
 * @property string|null $info
 * @property float|null $pos_x
 * @property float|null $pos_y
 */
class Device extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'device';
    }

    /**
     * @return array
     */
    public static function kksDevices() {
        return ArrayHelper::map(Device::find()->all(), 'id', 'kks');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['plant_id', 'name'], 'required'],
            [['plant_id', 'location_id', 'state_id', 'value'], 'integer'],
            [['pos_x', 'pos_y'], 'number'],
            [['short_name', 'name', 'kks'], 'string', 'max' => 100],
            [['info'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'plant_id' => 'Plant ID',
            'location_id' => 'Location ID',
            'state_id' => 'State ID',
            'short_name' => 'Short Name',
            'name' => 'Name',
            'kks' => 'Kks',
            'value' => 'Value',
            'info' => 'Info',
            'pos_x' => 'Pos X',
            'pos_y' => 'Pos Y',
        ];
    }

    /**
     * Определение связи между Device и Plant
     * @return \yii\db\ActiveQuery
     */
    public function getPlant()
    {
        return $this->hasOne(Plant::class, ['id' => 'plant_id']);
    }

    /**
     * Определение связи между Device и Location
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasOne(Location::class, ['id' => 'location_id']);
    }

    /**
     * Определение связи между Device и StateDevice (определяет тип устройства и его состояния)
     * @return \yii\db\ActiveQuery
     */
    public function getStateDevice()
    {
        return $this->hasOne(StateDevice::class, ['id' => 'state_id']);
    }

    /**
     * Определение связи между Device и placard (получение массива Placard)
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getPlacards()
    {
        return $this->hasMany(Placard::class, ['id' => 'placard_id'])
            ->viaTable('placard_device', ['device_id' => 'id']);
    }

    /**
     * Получение списка плакатов в Json
     * @return string
     */
    public function getJsonPlacards()
    {
        $placards = ArrayHelper::toArray($this->placards, [
            'app\models\Placard' => [
                'id' => 'id',
                'name' => 'name',
                'image' => 'path',
            ],
        ]);
        return JSON::encode($placards);
    }

    /**
     * @return string
     */
    public function getColorPlant()
    {
        $defaultColor = '#102027';
        $plant = $this->plant;
        return $plant ? $plant->color : $defaultColor;
    }
}
