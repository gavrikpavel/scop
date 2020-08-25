<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%log}}`.
 */
class m200408_094405_drop_record_id_column_from_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('log', 'record_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('log', 'record_id', $this->integer());
    }
}
