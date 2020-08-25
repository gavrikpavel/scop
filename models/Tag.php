<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "Tag".
 *
 * @property int $id
 * @property string|null $name
 * @property float|null $value
 */
class Tag extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'number'],
            [['name'], 'string', 'max' => 100],
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
            'value' => 'Value',
        ];
    }

    public function getMonthStateBdm($month) {
        return array(
            'state' => 2,
            'work' => 44,
            'break' => 5,
            'stop' => 10,
            );
    }
}
