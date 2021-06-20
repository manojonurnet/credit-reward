<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customers".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property int|null $reward
 * @property string $created_date
 * @property string $modified_date
 *
 * @property Currency $currency
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            [['reward'], 'integer'],
            [['name', 'email'], 'string', 'max' => 128],
            [['email'], 'unique'],
            [['created_date', 'modified_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'reward' => 'Reward',
            'created_date' => 'Created Date',
            'modified_date' => 'Modified Date',
        ];
    }

    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['customer_id' => 'id']);
    }

    public function getRewards()
    {
        return $this->hasMany(Reward::className(), ['order_id' => 'id'])->via('orders');
    }

    public function getClaims()
    {
        return $this->hasMany(Claim::className(), ['order_id' => 'id'])->via('orders');
    }
}
