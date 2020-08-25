<?php

use yii\db\Migration;

/**
 * Class m200427_165601_correct_smena_table
 */
class m200427_165601_correct_smena_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('smena', 'user1_id');
        $this->dropColumn('smena', 'user2_id');

        $this->addColumn('smena', 'date_in', $this->dateTime());
        $this->addColumn('smena', 'date_out', $this->dateTime());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('smena', 'user1_id', $this->integer());
        $this->addColumn('smena', 'user2_id', $this->integer());

        $this->dropColumn('smena', 'date_in');
        $this->dropColumn('smena', 'date_out');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200427_165601_correct_smena_table cannot be reverted.\n";

        return false;
    }
    */
}
