<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "placard".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $path
 */
class Placard extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'placard';
    }

    /**
     * @return array
     */
    public static function namePlacards() {
        return ArrayHelper::map(Placard::find()->all(), 'name', 'path');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 20],
            [['path'], 'string', 'max' => 255],
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
            'path' => 'Path',
        ];
    }
}
