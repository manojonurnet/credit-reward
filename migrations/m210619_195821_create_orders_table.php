<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orders}}`.
 */
class m210619_195821_create_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey(),
            'detail' => $this->string(512)->notNull(),
            'customer_id' => $this->integer()->notNull(),
            'sale_amount' => $this->decimal(9,2)->notNull(),
            'currency_id' => $this->integer()->notNull(),
            'status' => $this->tinyInteger(1)->defaultValue(0),
            'created_date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);

        $this->addForeignKey(
            'fk-orders-customer_id',
            'orders',
            'customer_id',
            'customers',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-orders-currency_id',
            'orders',
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
            'fk-orders-customer_id',
            'orders',
        );

        $this->dropForeignKey(
            'fk-orders-currency_id',
            'orders',
        );

        $this->dropTable('{{%orders}}');
    }
}
