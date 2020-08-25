<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%state_device}}`.
 * Описание состояния оборудования. Строковое описание для 0 и для 1
 */
class m200318_125212_create_state_device_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%state_device}}', [
            'id' => $this->primaryKey(),
            'name' => $this->char(100),
            'state_0' => $this->string(),
            'state_1' => $this->string(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%state_device}}');
    }
}