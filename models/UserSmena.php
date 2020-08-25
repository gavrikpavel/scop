<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_smena".
 *
 * @property int $id
 * @property int|null $smena_id
 * @property int|null $user_id
 */
class UserSmena extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_smena';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['smena_id', 'user_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'smena_id' => 'Smena ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @param $id
     * @param $user
     */
    public function saveUserInSmena($id, $user)
    {
        $this->smena_id = $id;
        $this->user_id = $user;
        $this->save();
    }
}
