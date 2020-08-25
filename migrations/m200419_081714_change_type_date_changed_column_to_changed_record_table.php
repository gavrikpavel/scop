<?php

use yii\db\Migration;

/**
 * Class m200419_081714_change_type_date_changed_column_to_changed_record_table
 */
class m200419_081714_change_type_date_changed_column_to_changed_record_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('changed_record', 'date_changed', $this->dateTime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('changed_record', 'date_changed', $this->date());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200419_081714_change_type_date_changed_column_to_changed_record_table cannot be reverted.\n";

        return false;
    }
    */
}
