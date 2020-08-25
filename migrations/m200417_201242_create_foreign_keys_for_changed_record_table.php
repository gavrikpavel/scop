<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%foreign_keys_for_changed_record}}`.
 */
class m200417_201242_create_foreign_keys_for_changed_record_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex(
            'idx-changed_record-record_id',
            'changed_record',
            'record_id'
        );

        $this->addForeignKey(
            'fk-changed_record-record_id',
            'changed_record',
            'record_id',
            'record',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
