<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rewards}}`.
 */
class m210619_204627_create_rewards_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%rewards}}', [
            'id' => $this->primaryKey(),
            'points' => $this->integer(),
            'amount' => $this->decimal(9,2),
            'status' => $this->tinyInteger(1),
            'order_id' => $this->integer()->notNull(),
            'created_date' => $this->timestamp(),
            'modified_date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk-rewards-order_id',
            'rewards',
            'order_id',
            'orders',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-rewards-order_id',
            'rewards',
        );
        $this->dropTable('{{%rewards}}');
    }
}
