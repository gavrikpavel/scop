<?php

use yii\db\Migration;

/**
 * Class m200421_064859_change_type_plant_id_column_from_record_table
 */
class m200421_064859_change_type_plant_id_column_from_record_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('record', 'plant_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200421_064859_change_type_plant_id_column_from_record_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200421_064859_change_type_plant_id_column_from_record_table cannot be reverted.\n";

        return false;
    }
    */
}
