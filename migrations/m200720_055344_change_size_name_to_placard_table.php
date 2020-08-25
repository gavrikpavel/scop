<?php

use yii\db\Migration;

/**
 * Class m200720_055344_change_size_name_to_placard_table
 */
class m200720_055344_change_size_name_to_placard_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('placard', 'name', $this->char(100));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200720_055344_change_size_name_to_placard_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200720_055344_change_size_name_to_placard_table cannot be reverted.\n";

        return false;
    }
    */
}
