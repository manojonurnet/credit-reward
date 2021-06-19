<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property string $product
 * @property float $price
 * @property int $customer_id
 * @property float $sale_amount
 * @property string $created_date
 * @property string $modified_date
 *
 * @property Customer $customer
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product', 'price', 'customer_id', 'sale_amount'], 'required'],
            [['price', 'sale_amount'], 'number'],
            [['customer_id'], 'integer'],
            [['status'], 'integer'],
            [['created_date', 'modified_date'], 'safe'],
            [['product'], 'string', 'max' => 512],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product' => 'Product',
            'price' => 'Price',
            'customer_id' => 'Customer ID',
            'sale_amount' => 'Sale Amount',
            'created_date' => 'Created Date',
            'modified_date' => 'Modified Date',
        ];
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }
}
