<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%changed_record}}`.
 */
class m200417_200140_add_record_id_column_to_changed_record_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('changed_record', 'record_id', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('changed_record', 'record_id');
    }
}
