<?php

namespace app\modules\orders\models\users;

use Yii;

use app\modules\orders\models\orders\Orders;


/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $full_name
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name'], 'required'],
            [['first_name', 'last_name'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('orders', 'ID'),
            'first_name' => Yii::t('orders', 'First Name'),
            'last_name'  => Yii::t('orders', 'Last Name'),

            'full_name'  => Yii::t('orders', 'Full Name'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }

    /**
     * @return string
     */
    public function getFull_name()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getOrders()
    {
        return $this->hasMany(
            Orders::class,
            ['user_id' => 'id']
        )->inverseOf('user');
    }
}
