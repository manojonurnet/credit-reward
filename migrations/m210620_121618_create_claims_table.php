<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%claims}}`.
 */
class m210620_121618_create_claims_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%claims}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'points' => $this->integer()->notNull(),
            'created_date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_date' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk-claims-order_id',
            'claims',
            'order_id',
            'orders',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-claims-order_id',
            'claims',
        );
        $this->dropTable('{{%claims}}');
    }
}
