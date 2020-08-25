<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "location".
 *
 * @property int $id
 * @property int $plant_id
 * @property string $name
 */
class Location extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'location';
    }

    /**
     * @return array
     */
    public static function nameLocations()
    {
        return ArrayHelper::map(Location::find()->all(), 'id', 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['plant_id', 'name'], 'required'],
            [['plant_id'], 'integer'],
            [['name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'plant_id' => 'Plant ID',
            'name' => 'Name',
        ];
    }

    /**
     * Определение связи между Location и Plant
     * @return \yii\db\ActiveQuery
     */
    public function getPlant()
    {
        return $this->hasOne(Plant::class, ['id' => 'plant_id']);
    }

    /**
     * Определение связей между Location и Device
     * @return \yii\db\ActiveQuery
     */
    public function getDevices()
    {
        return $this->hasMany(Device::class, ['location_id' => 'id']);
    }
}
