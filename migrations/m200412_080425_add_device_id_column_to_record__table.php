<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%record_}}`.
 */
class m200412_080425_add_device_id_column_to_record__table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('record', 'device_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('record', 'device_id');
    }
}
