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
 * @property string $fullName
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
            'id' => Yii::t('app', 'orders.labels.id'),
            'first_name' => Yii::t('app', 'orders.labels.first_name'),
            'last_name' => Yii::t('app', 'orders.labels.last_name'),
        ];
    }

    /**
     * {@inheritdoc}
     * 
     * @return UsersQuery the active query used by this AR class
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }

    /**
     * @return string user's full name
     */
    public function getFullName()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    /**
     * @return Orders all orders according to current user
     */
    public function getOrders()
    {
        return $this->hasMany(
            Orders::class,
            ['user_id' => 'id']
        )->inverseOf('user');
    }
}
