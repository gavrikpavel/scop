<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tag_log}}`.
 */
class m200710_100011_create_tag_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tag_log}}', [
            'id' => $this->primaryKey(),
            'device_id' => $this->integer(),
            'value' => $this->boolean(),
            'date' => $this->dateTime(),
        ]);

        $this->createIndex(
            'idx-tag_log-device_id',
            'tag_log',
            'device_id'
        );

        $this->createIndex(
            'idx-tag_log-date',
            'tag_log',
            'date'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tag_log}}');
    }
}
