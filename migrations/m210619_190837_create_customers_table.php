<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customers}}`.
 */
class m210619_190837_create_customers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customers}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
            'email' => $this->string(128)->notNull()->unique(),
            'currency_id' => $this->integer()->notNull(),
            'reward' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-customer-currency_id',
            'customers',
            'currency_id',
            'currencies',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-customer-currency_id',
            'customers',
        );
        $this->dropTable('{{%customers}}');
    }
}
