<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%plant}}`.
 */
class m200416_123935_add_area_viewbox_column_to_plant_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('plant', 'area_viewbox', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('plant', 'area_viewbox');
    }
}
