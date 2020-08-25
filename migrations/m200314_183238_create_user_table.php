<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 * Пользователь системы
 */
class m200314_183238_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'smena_id' => $this->integer(),
            'name'=>$this->string(),
            'surname'=>$this->string(),
            'patronymic'=>$this->string(),
            'short_name'=>$this->char(100),
            'position'=>$this->string(),
            'password'=>$this->string(),
            'photo'=>$this->string(),
            'isAdmin'=>$this->integer()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
