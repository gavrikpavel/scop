<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%device}}`.
 * Устройство на электрической схеме
 */
class m200313_194230_create_device_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%device}}', [
            'id' => $this->primaryKey(),
            'plant_id' => $this->integer()->notNull(),
            'location_id' => $this->integer(),
            'state_id' => $this->integer(),
            'short_name' => $this->char(100),
            'name' => $this->char(100)->notNull(),
            'kks' => $this->char(100),
            'value' => $this->boolean()->defaultValue(0),
            'info' => $this->string(),
            'pos_x' => $this->float()->defaultValue(0),
            'pos_y' => $this->float()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%device}}');
    }
}
