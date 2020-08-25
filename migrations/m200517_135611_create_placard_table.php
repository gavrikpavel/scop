<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%placard}}`.
 */
class m200517_135611_create_placard_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%placard}}', [
            'id' => $this->primaryKey(),
            'name' => $this->char(20),
            'path' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%placard}}');
    }
}
