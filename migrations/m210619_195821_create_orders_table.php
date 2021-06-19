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
            'product' => $this->string(512)->notNull(),
            'price' => $this->decimal(9,2)->notNull(),
            'customer_id' => $this->integer()->notNull(),
            'sale_amount' => $this->decimal(9,2)->notNull(),
            'status' => $this->tinyInteger(1)->defaultValue(0),
            'created_date' => $this->timestamp(),
            'modified_date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk-orders-customer_id',
            'orders',
            'customer_id',
            'customers',
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
        $this->dropTable('{{%orders}}');
    }
}
