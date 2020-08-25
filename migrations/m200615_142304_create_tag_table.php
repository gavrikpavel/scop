<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tag}}`.
 */
class m200615_142304_create_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tag}}', [
            'id' => $this->primaryKey(),
            'name' => $this->char(100),
            'value' => $this->float(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tag}}');
    }
}
