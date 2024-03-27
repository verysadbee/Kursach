<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Products".
 *
 * @property int $product_id
 * @property string|null $product_name
 * @property string|null $description
 * @property float|null $price
 * @property int|null $stock_quantity
 *
 * @property OrderDetails[] $orderDetails
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'stock_quantity'], 'integer'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['product_name'], 'string', 'max' => 100],
            [['product_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'product_name' => 'Product Name',
            'description' => 'Description',
            'price' => 'Price',
            'stock_quantity' => 'Stock Quantity',
        ];
    }

    /**
     * Gets query for [[OrderDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetails()
    {
        return $this->hasMany(OrderDetails::class, ['product_id' => 'product_id']);
    }
}
