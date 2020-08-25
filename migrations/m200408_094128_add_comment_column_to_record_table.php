<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%record}}`.
 */
class m200408_094128_add_comment_column_to_record_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('record', 'comment', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('record', 'comment');
    }
}
