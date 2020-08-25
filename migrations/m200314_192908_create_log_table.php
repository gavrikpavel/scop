<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%log}}`.
 * Действия пользователя
 */
class m200314_192908_create_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%log}}', [
            'id' => $this->primaryKey(),
            'device_id' => $this->integer(),
            'record_id' => $this->integer(),
            'value' => $this->boolean(),
            'date' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%log}}');
    }
}
