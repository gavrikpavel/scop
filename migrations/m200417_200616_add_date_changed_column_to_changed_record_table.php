<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%changed_record}}`.
 */
class m200417_200616_add_date_changed_column_to_changed_record_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('changed_record', 'date_changed', $this->date()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('changed_record', 'date_changed');
    }
}
