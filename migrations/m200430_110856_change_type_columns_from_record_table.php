<?php

use yii\db\Migration;

/**
 * Class m200430_110856_change_type_columns_from_record_table
 */
class m200430_110856_change_type_columns_from_record_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('record', 'plant_id', $this->text());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('record', 'plant_id', $this->text()->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200430_110856_change_type_columns_from_record_table cannot be reverted.\n";

        return false;
    }
    */
}
