<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%record}}`.
 * Запись в оперативном журнале
 */
class m200313_194121_create_record_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%record}}', [
            'id' => $this->primaryKey(),
            'plant_id' => $this->integer()->notNull(),
            'user_id' => $this->string()->notNull(),
            'text' => $this->string()->notNull(),
            'date_event' => $this->dateTime(),            
            'date' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%record}}');
    }
}
