<?php

namespace app\modules\orders\models\orders;

use app\modules\orders\models\services\Services;
use app\modules\orders\models\users\Users;

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
    public static function modes(): array
    {
        return [
            self::MODE_MANUAL => Yii::t('app', 'orders.modes.manual'),
            self::MODE_AUTO   => Yii::t('app', 'orders.modes.auto'),
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
    public static function statuses(): array
    {
        return [
            self::STATUS_PENDING     => Yii::t('app', 'orders.statuses.pending'),
            self::STATUS_IN_PROGRESS => Yii::t('app', 'orders.statuses.in_progress'),
            self::STATUS_COMPLETED   => Yii::t('app', 'orders.statuses.completed'),
            self::STATUS_CANCELED    => Yii::t('app', 'orders.statuses.canceled'),
            self::STATUS_FAIL        => Yii::t('app', 'orders.statuses.fail'),
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
            'id'         => Yii::t('app', 'orders.labels.id'),
            'user_id'    => Yii::t('app', 'orders.labels.user_id'),
            'service_id' => Yii::t('app', 'orders.labels.service_id'),
            'link'       => Yii::t('app', 'orders.labels.link'),
            'quantity'   => Yii::t('app', 'orders.labels.quantity'),
            'status'     => Yii::t('app', 'orders.labels.status'),
            'created_at' => Yii::t('app', 'orders.labels.created'),
            'mode'       => Yii::t('app', 'orders.labels.mode'),

            'user'       => Yii::t('app', 'orders.labels.user'),
            'service'    => Yii::t('app', 'orders.labels.service'),
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

    /**
     * @return array
     */
    public function getFormateCreatedAt()
    {
        $dt = new \DateTime();
        $dt->setTimestamp($this->created_at);

        return [$dt->format('Y-m-d'), $dt->format('H:m:s')];
    }

    public function getStatusName(): string
    {
        return self::statuses()[$this->status];
    }

    public function getModeName(): string
    {
        return self::modes()[$this->mode];
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
    public static function getTotal_count(): int
    {
        return self::find()->count();
    }
}
