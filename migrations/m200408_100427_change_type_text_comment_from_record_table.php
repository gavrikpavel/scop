<?php

use yii\db\Migration;

/**
 * Class m200408_100427_change_type_text_comment_from_record_table
 */
class m200408_100427_change_type_text_comment_from_record_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('record', 'text', $this->text());
        $this->alterColumn('record', 'comment', $this->text());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('record', 'text', $this->string());
        $this->alterColumn('record', 'comment', $this->string());

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200408_100427_change_type_text_comment_from_record_table cannot be reverted.\n";

        return false;
    }
    */
}
