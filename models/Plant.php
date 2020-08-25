<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "plant".
 *
 * @property int $id
 * @property string $name
 * @property string $area_viewbox
 */
class Plant extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plant';
    }

    /**
     * @return array
     */
    public static function namePlants() {
        return ArrayHelper::map(Plant::find()->all(), 'id', 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'area_viewbox'], 'string', 'max' => 200],
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
            'area_viewbox' => 'Area ViewBox'
        ];
    }

    /**
     * Определение связей между Plant и Locations
     * @return \yii\db\ActiveQuery
     */
    public function getLocations()
    {
        return $this->hasMany(Location::class, ['plant_id' => 'id']);
    }

    /**
     * Определение связей между Plant и Devices
     * @return \yii\db\ActiveQuery
     */
    public function getDevices()
    {
        return $this->hasMany(Device::class, ['plant_id' => 'id']);
    }
}
