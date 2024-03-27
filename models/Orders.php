<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Orders".
 *
 * @property int $order_id
 * @property int|null $status_id
 * @property int|null $user_id
 * @property string|null $order_date
 * @property float|null $total_amount
 *
 * @property OrderDetails[] $orderDetails
 * @property OrderStatus $status
 * @property Users $user
 */
class Orders extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_IN_PROGRESS = 2;
    const STATUS_COMPLETED = 3;

    // Определите метод, который возвращает текстовое описание статуса
    public function getStatusDescription()
    {
        switch ($this->status_id) {
            case self::STATUS_NEW:
                return 'Новое';
            case self::STATUS_IN_PROGRESS:
                return 'В процессе';
            case self::STATUS_COMPLETED:
                return 'Завершено';
            default:
                return 'Неизвестно';
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id','quantity'], 'integer'],
            [['status_id', 'user_id'], 'integer'],
            [['order_date'], 'safe'],
            [['total_amount'], 'number'],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrderStatus::class, 'targetAttribute' => ['status_id' => 'status_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'order_id' => 'Order ID',
            'status_id' => 'Status ID',
            'user_id' => 'User ID',
            'order_date' => 'Order Date',
            'total_amount' => 'Total Amount',
            'quantity' => 'Quantity',
        ];
    }

    /**
     * Gets query for [[OrderDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetails()
    {
        return $this->hasMany(OrderDetails::class, ['order_id' => 'order_id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(OrderStatus::class, ['status_id' => 'status_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['user_id' => 'user_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Products::class, ['product_id' => 'product_id']);
    }
}
