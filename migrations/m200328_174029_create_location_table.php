<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%location}}`.
 */
class m200328_174029_create_location_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%location}}', [
            'id' => $this->primaryKey(),
            'plant_id' => $this->integer()->notNull(),
            'name' => $this->char(200)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%location}}');
    }
}
