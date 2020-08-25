<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $name
 * @property string|null $surname
 * @property string|null $patronymic
 * @property string|null $short_name
 * @property string|null $position
 * @property string|null $password
 * @property string|null $photo
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @return array
     */
    public static function shortNameUsers()
    {
        return ArrayHelper::map(User::find()->all(), 'id', 'short_name');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'patronymic', 'position', 'password', 'photo'], 'string', 'max' => 255],
            [['short_name', 'username'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'patronymic' => 'Отчество',
            'short_name' => 'Фамилия и Инициалы',
            'position' => 'Должность',
            'password' => 'Пароль',
            'photo' => 'Фото',
        ];
    }

    /**
     * @param int|string $id
     * @return User|IdentityInterface|null
     */
    public static function findIdentity($id)
    {
        return User::findOne($id);
    }

    /**
     * @param $username
     * @return User|array|ActiveRecord|null
     */
    public static function findByUsername($username)
    {
        return User::find()->where(['username' => $username])->one();
    }

    /**
     * @param mixed $token
     * @param null $type
     * @return void|IdentityInterface|null
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {}

    /**
     * @param $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return ($this->password === $password) ? true : false;
    }

    /**
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|void
     */
    public function getAuthKey()
    {}

    /**
     * @param string $authKey
     * @return bool|void
     */
    public function validateAuthKey($authKey)
    {}

    /**
     * Определение связей между таблицами User и Record
     * @return \yii\db\ActiveQuery
     */
    public function getRecords()
    {
        return $this->hasMany(Record::class, ['user_id' => 'id']);
    }
}