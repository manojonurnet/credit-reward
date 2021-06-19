<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rewards".
 *
 * @property int $id
 * @property int|null $points
 * @property float|null $amount
 * @property int|null $status
 * @property string|null $expiry_date
 * @property int $order_id
 * @property string $created_date
 * @property string $modified_date
 *
 * @property Order $order
 */
class Reward extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rewards';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['points', 'status', 'order_id'], 'integer'],
            [['amount'], 'number'],
            [['expiry_date', 'created_date', 'modified_date'], 'safe'],
            [['order_id'], 'required'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'points' => 'Points',
            'amount' => 'Amount',
            'status' => 'Status',
            'expiry_date' => 'Expiry Date',
            'order_id' => 'Order ID',
            'created_date' => 'Created Date',
            'modified_date' => 'Modified Date',
        ];
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }
}
