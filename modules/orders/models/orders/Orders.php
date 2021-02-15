<?php

namespace app\modules\orders\models\orders;

use Yii;

use app\components\DateTimeTools;
use app\modules\orders\models\services\Services;
use app\modules\orders\models\users\Users;

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
    public const MODE_MANUAL = 0;
    public const MODE_AUTO = 1;

    public const STATUS_PENDING = 0;
    public const STATUS_IN_PROGRESS = 1;
    public const STATUS_COMPLETED = 2;
    public const STATUS_CANCELED = 3;
    public const STATUS_FAIL = 4;

    /**
     * @return array with modes as keys and text representation as values
     */
    public static function getModes(): array
    {
        return [
            self::MODE_MANUAL => Yii::t('app', 'orders.modes.manual'),
            self::MODE_AUTO => Yii::t('app', 'orders.modes.auto'),
        ];
    }

    /**
     * @return array with statuses as keys and text representation as values
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_PENDING => Yii::t('app', 'orders.statuses.pending'),
            self::STATUS_IN_PROGRESS => Yii::t('app', 'orders.statuses.in_progress'),
            self::STATUS_COMPLETED => Yii::t('app', 'orders.statuses.completed'),
            self::STATUS_CANCELED => Yii::t('app', 'orders.statuses.canceled'),
            self::STATUS_FAIL => Yii::t('app', 'orders.statuses.fail'),
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
            'id' => Yii::t('app', 'orders.labels.id'),
            'user_id' => Yii::t('app', 'orders.labels.user_id'),
            'service_id' => Yii::t('app', 'orders.labels.service_id'),
            'link' => Yii::t('app', 'orders.labels.link'),
            'quantity' => Yii::t('app', 'orders.labels.quantity'),
            'status' => Yii::t('app', 'orders.labels.status'),
            'created_at' => Yii::t('app', 'orders.labels.created'),
            'mode' => Yii::t('app', 'orders.labels.mode'),

            'user' => Yii::t('app', 'orders.labels.user'),
            'service' => Yii::t('app', 'orders.labels.service'),
        ];
    }

    /**
     * {@inheritdoc}
     * 
     * @return OrdersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrdersQuery(get_called_class());
    }

    /**
     * @see:formatTimestamp \app\components\DateTimeTools::formatTimestamp
     * 
     * @return array with formatted created_at field 
     * or corresponding error message
     */
    public function getFormattedCreatedAt(): array
    {
        return DateTimeTools::formatTimestamp($this->created_at);
    }

    /**
     * @return string text representation of current mode
     */
    public function getModeName(): string
    {
        return self::getModes()[$this->mode];
    }

    /**
     * @return string text representation of current status
     */
    public function getStatusName(): string
    {
        return self::getStatuses()[$this->status];
    }

    /**
     * @return Users corresponding user instance
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    /**
     * @return Services corresponding service instance
     */
    public function getService()
    {
        return $this->hasOne(Services::class, ['id' => 'service_id']);
    }

    /**
     * @return int total count of orders
     */
    public static function getTotalCount(): int
    {
        return (int) self::find()->count();
    }
}
