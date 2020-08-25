<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%changed_record}}`.
 */
class m200417_194732_create_changed_record_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%changed_record}}', [
            'id' => $this->primaryKey(),
            'plant_id' => $this->integer()->notNull(),
            'user_id' => $this->string()->notNull(),
            'text' => $this->text()->notNull(),
            'date_event' => $this->dateTime(),
            'date' => $this->dateTime(),
            'comment' => $this->text(),
            'device_id' =>  $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%changed_record}}');
    }
}
