<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%plant}}`.
 * Место установки оборудования
 */
class m200313_194212_create_plant_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%plant}}', [
            'id' => $this->primaryKey(),
            'name' => $this->char(200)->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%plant}}');
    }
}
