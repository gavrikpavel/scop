<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%user}}`.
 */
class m200414_182609_drop_is_admin_column_from_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('user', 'is_admin');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('user', 'is_admin', $this->integer());
    }
}
