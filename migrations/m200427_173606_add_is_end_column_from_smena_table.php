<?php

use yii\db\Migration;

/**
 * Class m200427_173606_add_is_end_column_from_smena_table
 */
class m200427_173606_add_is_end_column_from_smena_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('smena', 'is_end', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('smena', 'is_end');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200427_173606_add_is_end_column_from_smena_table cannot be reverted.\n";

        return false;
    }
    */
}
