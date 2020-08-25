<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%record}}`.
 */
class m200418_175725_add_changed_column_to_record_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('record', 'changed', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('record', 'changed');
    }
}
