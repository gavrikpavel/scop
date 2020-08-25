<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "smena".
 *
 * @property int $id
 * @property string $date_in
 * @property string $date_out
 * @property string $is_end
 */
class Smena extends ActiveRecord
{
    public $usersInSmena;
    public $comment;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'smena';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usersInSmena'], 'required'],
            [['usersInSmena'], 'validateUserSmena'],
            [['comment'], 'string'],
        ];
    }

    /**
     * Валидация при приеме смены.
     * Один из выбранных пользователей должен быть равен авторизованному пользователю
     */
    public function validateUserSmena()
    {
        if (!$this->checkOutSmena()) {
            $this->addError('usersInSmena', Yii::$app->user->identity->short_name . ' должен быть в смене!');
        }
    }

    /**
     * Сдавать смену только если в смене есть пользователь авторизованный в системе
     * @return bool
     */
    public function checkOutSmena()
    {
        $currentUser = Yii::$app->user->identity->getId();
        $users = $this->getIdUsers($this->usersInSmena);
        $checkFlag = false;

        foreach ($users as $user) {
            if ($user === $currentUser) {
                $checkFlag =  true;
            }
        }
        return $checkFlag;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usersInSmena' => 'Персонал в смене',
            'comment' => 'Комментарий',
        ];
    }

    /**
     * Сохранение пользователей в смене
     */
    public function takeSmena()
    {
        $users = $this->getIdUsers($this->usersInSmena);
        $this->date_in = date("Y-m-d H:i:s");
        if ($this->save())
        {
            foreach ($users as $user) {
                $userSmena = new UserSmena();
                $userSmena->saveUserInSmena($this->id, $user);
            }
        }
    }

    /**
     * Сохранение даты выхода из смены
     */
    public function giveSmena()
    {
        if (!$this->is_end) {
            $this->date_out = date("Y-m-d H:i:s");
            $this->is_end = true;
            $this->save();
        }
    }

    /**
     * Формирование текста записи для сохранения в Record
     * @param $str
     * @return string
     */
    public function setText($str)
    {
        $users = $this->getIdUsers($this->usersInSmena);
        $nameUsers = '';
        $separator = ', ';

        foreach ($users as $user) {
            $nameUsers = $nameUsers . User::findOne($user)->short_name . $separator;
        }
        $nameUsers = rtrim($nameUsers, $separator);

        return 'Смена. ' . $nameUsers. ' '  . $str . ' смену.';
    }

    /**
     * Получение списка приема/сдачи смены за 3 месяца
     * @param int $countMonthAgo
     * @return array
     */
    public function getSmenaEvents($countMonthAgo = 3)
    {
        $smenaEvents = [];
        $eventKeys = ['title', 'description', 'start', 'end'];

        $lastDate = date('Y-m-d H:i:s', strtotime('-' . $countMonthAgo . ' month'));
        $sampleSmena = Smena::find()->where(['>', 'date_in', $lastDate])->all();

        foreach ($sampleSmena as $smena) {
            $users = $smena->users;
            $nameUsers = '';
            foreach ($users as $user) {
                $nameUsers = $nameUsers . $user->short_name . ', ';
            }
            $nameUsers = rtrim($nameUsers, ', ');


            $event = [];
            array_push($event,
                $nameUsers,
                $nameUsers,
                $smena->date_in,
                $smena->date_out
            );
            $smenaEvents[] = array_combine($eventKeys, $event);
        }

        return $smenaEvents;
    }

    /**
     * Обработка массива пользователей из Multiple Select2
     * @param $users
     * @return array
     */
    public function getIdUsers($users)
    {
        $arrId = array_values($users);
        foreach ($arrId as &$id) {
            $id = intval(strip_tags($id));
        }
        unset($id); // разорвать ссылку на последний элемент
        return $arrId;
    }

    /**
     * Получение массива пользователей из смены
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])
            ->viaTable('user_smena', ['smena_id' => 'id']);
    }
}
