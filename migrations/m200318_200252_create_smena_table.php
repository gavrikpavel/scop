<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%smena}}`.
 * Смена включает в себя 2-х пользователей
 */
class m200318_200252_create_smena_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%smena}}', [
            'id' => $this->primaryKey(),
            'user1_id' => $this->integer()->notNull(),
            'user2_id' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%smena}}');
    }
}
