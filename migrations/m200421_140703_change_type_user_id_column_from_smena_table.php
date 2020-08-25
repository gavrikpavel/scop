<?php

use yii\db\Migration;

/**
 * Class m200421_140703_change_type_user_id_column_from_smena_table
 */
class m200421_140703_change_type_user_id_column_from_smena_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('smena', 'user1_id', $this->integer()->defaultValue(0));
        $this->alterColumn('smena', 'user2_id', $this->integer()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200421_140703_change_type_user_id_column_from_smena_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200421_140703_change_type_user_id_column_from_smena_table cannot be reverted.\n";

        return false;
    }
    */
}
