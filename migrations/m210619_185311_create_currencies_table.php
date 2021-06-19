<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%currencies}}`.
 */
class m210619_185311_create_currencies_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%currencies}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(3)->notNull()->unique(),
            'value' => $this->decimal(5,2)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%currencies}}');
    }
}
