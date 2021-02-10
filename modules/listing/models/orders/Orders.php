<?php

namespace app\modules\listing\models\orders;

use app\modules\listing\models\services\Services;
use app\modules\listing\models\users\Users;

use Yii;


/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int $user_id
 * @property string $link
 * @property int $quantity
 * @property int $service_id
 * @property int $status 0 - Pending, 1 - In progress, 2 - Completed, 3 - Canceled, 4 - Fail
 * @property int $created_at
 * @property int $mode 0 - Manual, 1 - Auto
 */
class Orders extends \yii\db\ActiveRecord
{
    const MODE_MANUAL = 0;
    const MODE_AUTO   = 1;

    /**
     * @return array
     */
    public static function modes()
    {
        return [
            self::MODE_MANUAL => Yii::t('listing', 'Manual'),
            self::MODE_AUTO   => Yii::t('listing', 'Auto'),
        ];
    }

    const STATUS_PENDING     = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_COMPLETED   = 2;
    const STATUS_CANCELED    = 3;
    const STATUS_FAIL        = 4;

    /**
     * @return array
     */
    public static function statuses()
    {
        return [
            self::STATUS_PENDING     => Yii::t('listing', 'Pending'),
            self::STATUS_IN_PROGRESS => Yii::t('listing', 'In progress'),
            self::STATUS_COMPLETED   => Yii::t('listing', 'Completed'),
            self::STATUS_CANCELED    => Yii::t('listing', 'Canceled'),
            self::STATUS_FAIL        => Yii::t('listing', 'Fail'),
        ];
    }

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
            [['user_id', 'link', 'quantity', 'service_id', 'status', 'created_at', 'mode'], 'required'],
            [['user_id', 'quantity', 'service_id', 'status', 'created_at', 'mode'], 'integer'],
            [['link'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('listing', 'ID'),
            'user_id'    => Yii::t('listing', 'User ID'),
            'link'       => Yii::t('listing', 'Link'),
            'quantity'   => Yii::t('listing', 'Quantity'),
            'service_id' => Yii::t('listing', 'Service ID'),
            'status'     => Yii::t('listing', 'Status'),
            'created_at' => Yii::t('listing', 'Created'),
            'mode'       => Yii::t('listing', 'Mode'),

            'user'       => Yii::t('listing', 'User'),
            'service'    => Yii::t('listing', 'Service'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return OrdersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrdersQuery(get_called_class());
    }

    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    public function getService()
    {
        return $this->hasOne(Services::class, ['id' => 'service_id']);
    }

    /**
     * @return int|string
     */
    public static function getTotal_count()
    {
        return self::find()->count();
    }
}
