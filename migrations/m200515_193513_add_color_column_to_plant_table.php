<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%plant}}`.
 */
class m200515_193513_add_color_column_to_plant_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('plant', 'color', $this->string(20));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('plant', 'color');
    }
}
