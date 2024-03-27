<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Users".
 *
 * @property int $user_id
 * @property string|null $username
 * @property string|null $password
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $address
 * @property int|null $type_id
 *
 * @property Orders[] $orders
 * @property UserTypes $type
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type_id'], 'integer'],
            [['username', 'password'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 20],
            [['address'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserTypes::class, 'targetAttribute' => ['type_id' => 'type_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'phone' => 'Phone',
            'address' => 'Address',
            'type_id' => 'Type ID',
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::class, ['user_id' => 'user_id']);
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(UserTypes::class, ['type_id' => 'type_id']);
    }

    public function validatePassword($password)
    {
        return $this->password === $password;
    }
    public static function findIdentity($id)
    {
        return static::find()->where(['user_id' => $id])->one();
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }
    public function getAuthKey()
    {
        return null;
    }
    public function validateAuthKey($authKey)
    {
        return null;
    }

    public function getId() {
        return $this->user_id;
    }

    public static function login($login, $password) {
        $user = static::find()->where(['username' => $login])->one();

        if ($user && $user->validatePassword($password)) {
            return $user;
        }

        return null;
    }

    public function __toString()
    {
        return $this->username;
    }
}
