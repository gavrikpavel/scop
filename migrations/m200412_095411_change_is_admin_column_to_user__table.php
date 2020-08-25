<?php

use yii\db\Migration;

/**
 * Class m200412_095411_change_is_admin_column_to_user__table
 */
class m200412_095411_change_is_admin_column_to_user__table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('user', 'isAdmin', 'is_admin');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('user', 'is_admin', 'isAdmin');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200412_095411_change_is_admin_column_to_user__table cannot be reverted.\n";

        return false;
    }
    */
}
