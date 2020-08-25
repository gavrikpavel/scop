<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "record".
 *
 * @property int $id
 * @property int $plant_id
 * @property int $user_id
 * @property int $device_id
 * @property string $text
 * @property string $comment
 * @property string|null $date_event
 * @property string|null $date
 * @property boolean|null $changed
 */
class Record extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'record';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'required'],
            [['plant_id','user_id', 'device_id'], 'integer'],
            [['date_event', 'date'], 'string'],
            [['comment', 'text'], 'string'],
            [['user_id','date', 'changed'], 'safe']
        ];
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
            'device_id' => 'Оборудование',
            'text' => 'Действие',
            'comment' => 'Комментарий',
            'date_event' => 'Дата события',
            'date' => 'Дата записи',
            'changed' => 'Ред',
        ];
    }

    /**
     * Добавление записи в журнал из Схемы
     * @param $data
     */
    public function saveRecord($data)
    {
        $device = Device::findOne($data['id']);
        $this->date = date("Y-m-d H:i:s");
        $this->date_event = $data['dateTimeEvent'];
        $this->plant_id = $device->plant_id;
        $this->device_id = $device->id;
        $this->text = $this->getText($device);
        $this->comment = $data['comment'];
        $this->user_id = Yii::$app->user->id;
        $this->save();
    }

    /**
     * Добавление записи в журнал из АСУ ТП
     * @param $id
     */
    public function saveRecordDCS($id)
    {
        $device = Device::findOne($id);
        $this->date = date("Y-m-d H:i:s");
        $this->date_event = date("Y-m-d H:i:s");
        $this->plant_id = $device->plant_id;
        $this->device_id = $device->id;
        $this->text = $this->getTextDCS($device);
        $this->comment = "АСУ ТП ГТУ-ТЭЦ";
        $this->user_id = 1;
        $this->save();
    }

//    /**
//     * @param $data
//     * @return bool
//     */
//    public function saveRecordPlacard($data, $text)
//    {
//        $device = Device::findOne($data['deviceId']);
//        $placard = Placard::findOne($data['placardId']);
//
//        $this->date = date("Y-m-d H:i:s");
//        $this->date_event = $data['dateTimeEvent'];
//        $this->plant_id = $device->plant_id;
//        $this->device_id = $device->id;
//        $this->text = $device->name . '. ' . $text . ' - ' . $placard->name;
//        $this->comment = $data['comment'];
//        $this->user_id = Yii::$app->user->id;
//        $this->save();
//    }

    /**
     * @param $text
     * @param $comment
     */
    public function saveRecordSmena($text, $comment)
    {
        $this->date = date("Y-m-d H:i:s");
        $this->date_event = $this->date;
        $this->text = $text;
        $this->comment = $comment;
        $this->user_id = Yii::$app->user->id;
        $this->save();
    }

    /**
     * Сохранение записи, заполняемой из оперативного журнала
     */
    public function saveFromJournal()
    {
        $this->date = date("Y-m-d H:i:s");
        if (empty($this->date_event)) {
            $this->date_event = $this->date;
        }
        $this->user_id = Yii::$app->user->identity->getId();
        $this->save();
    }

    /**
     * Сохранение обновленной записи из оперативного журнала
     */
    public function updateFromJournal()
    {
        $this->changed = true;
        $this->save();
    }

    /**
     * Формирование текста в записи. Формирование = имя устройства + состояние
     * @param $device
     * @return string
     */
    public function getText($device)
    {
        $state = $device->stateDevice;
        if ($device->value === 1) {
            $stateDevice = $state->state_1;
        }
        else {
            $stateDevice = $state->state_0;
        }
        return $device->name . ' ' . $stateDevice;
    }

    /**
     * Формирование текста в записи для АСУ устройств. Формирование = имя устройства + состояние
     * @param $device
     * @return string
     */
    public function getTextDCS($device)
    {
        $stateDevice = '';

        // секционный разъединитель АСУ ТП
        if ($device->id === 10) {
            $state = $device->stateDevice;
            if ($device->value === 1) {
                $stateDevice = $state->state_1;
            }
            else {
                $stateDevice = $state->state_0;
            }
        }

        // заземляющий разъединитель АСУ ТП или выключатель простой АСУ ТП
        if ($device->id === 7 | $device->id === 8) {
            $state = $device->stateDevice;
            switch ($device->value) {
                case 0:
                    $stateDevice = 'ошибка!';
                    break;
                case 1:
                    $stateDevice = $state->state_1;
                    break;
                case 2:
                    $stateDevice = $state->state_0;
                    break;
            }
        }

        // выключатель простой АСУ ТП
        if ($device->id === 6) {
            switch ($device->value) {
                case 0:
                    $stateDevice = 'ошибка!';
                    break;
                case 1:
                    $stateDevice = 'включен и тележка вкачена';
                    break;
                case 2:
                    $stateDevice = 'отключен и тележка вкачена';
                    break;
                case 3:
                    $stateDevice = 'недостоверен и тележка вкачена';
                    break;
                case 10:
                    $stateDevice = 'включен и тележка выкачена';
                    break;
                case 20:
                    $stateDevice = 'отключен и тележка выкачена';
                    break;
                case 30:
                    $stateDevice = 'недостоверен и тележка выкачена';
                    break;
            }
        }

        return $device->name . ' ' . $stateDevice;
    }

    /**
     * Определение связи между Record и Plant
     * @return \yii\db\ActiveQuery
     */
    public function getPlant()
    {
        return $this->hasOne(Plant::class, ['id' => 'plant_id']);
    }

    /**
     * Определение связи между Record и User
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Определение связи между Record и Device
     * @return \yii\db\ActiveQuery
     */
    public function getDevice()
    {
        return $this->hasOne(Device::class, ['id' => 'device_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChangedRecords()
    {
        return $this->hasMany(ChangedRecord::class, ['record_id' => 'id']);
    }

    /**
     * Получение имени Plant для отображения в GridView (record/index)
     * @return string
     */
    public function getPlantName()
    {
        $plant = $this->plant;
        return $plant ? $plant->name : '';
    }

    /**
     * Получение короткого имени User для отображения в GridView (record/index)
     * @return string
     */
    public function getUserShortName()
    {
        $user = $this->user;
        return $user ? $user->short_name : '';
    }

    /**
     * Получение kks Device для отображения в GridView (record/index)
     * @return string
     */
    public function getDeviceKks()
    {
        $device = $this->device;
        return $device ? $device->kks : '';
    }

    /**
     * Получение shortName Device
     * @return string
     */
    public function getDeviceShortName()
    {
        $device = $this->device;
        return $device ? $device->short_name : '';
    }
}
