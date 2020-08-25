<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_smena}}`.
 */
class m200427_170133_create_user_smena_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_smena}}', [
            'id' => $this->primaryKey(),
            'smena_id' => $this->integer(),
            'user_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_smena}}');
    }
}
