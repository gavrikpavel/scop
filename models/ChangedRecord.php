<?php

namespace app\models;

/**
 * This is the model class for table "changed_record".
 *
 * @property int $id
 * @property int $plant_id
 * @property string $user_id
 * @property string $text
 * @property string|null $date_event
 * @property string|null $date
 * @property string|null $comment
 * @property int|null $device_id
 * @property int $record_id
 * @property string $date_changed
 *
 * @property Record $record
 */
class ChangedRecord extends Record
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'changed_record';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'plant_id' => 'РУ',
            'user_id' => 'Пользователь',
            'text' => 'Действие',
            'date_event' => 'Дата события',
            'date' => 'Дата записи',
            'comment' => 'Комментарий',
            'device_id' => 'Оборудование',
            'record_id' => 'Запись',
            'date_changed' => 'Дата изменения',
        ];
    }

    /**
     * @param $record
     */
    public function cloneRecord ($record)
    {
        $this->plant_id = $record->plant_id;
        $this->user_id = $record->user_id;
        $this->text = $record->text;
        $this->comment = $record->comment;
        $this->date_event = $record->date_event;
        $this->date = $record->date;
        $this->device_id = $record->device_id;
        $this->record_id = $record->id;
    }

    public function saveChangedRecord()
    {
        $this->date_changed = date("Y-m-d H:i:s");
        $this->save();
    }

    /**
     * Gets query for [[Record]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecord()
    {
        return $this->hasOne(Record::class, ['id' => 'record_id']);
    }

}
