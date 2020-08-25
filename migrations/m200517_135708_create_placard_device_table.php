<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%placard_device}}`.
 */
class m200517_135708_create_placard_device_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%placard_device}}', [
            'id' => $this->primaryKey(),
            'device_id'=> $this->integer(),
            'placard_id'=> $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%placard_device}}');
    }
}
