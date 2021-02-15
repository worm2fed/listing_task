<?php

namespace app\modules\orders\models\orders;

use Yii;

use app\components\DateTimeTools;
use app\components\UnbufferedConnection;
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
    public const MODE_AUTO   = 1;

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

    public const STATUS_PENDING     = 0;
    public const STATUS_IN_PROGRESS = 1;
    public const STATUS_COMPLETED   = 2;
    public const STATUS_CANCELED    = 3;
    public const STATUS_FAIL        = 4;

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
    public function getFormattedCreatedAt(): array
    {
        return DateTimeTools::formatTimestamp($this->created_at);
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
     * @return int
     */
    public static function getTotalCount(): int
    {
        return (int) self::find()->count();
    }

    public static function export(OrdersQuery $query)
    {
        $services = Services::getServicesArray();
        $columns = [
            Yii::t('app', 'orders.labels.id'),
            Yii::t('app', 'orders.labels.user'),
            Yii::t('app', 'orders.labels.link'),
            Yii::t('app', 'orders.labels.quantity'),
            Yii::t('app', 'orders.labels.service'),
            Yii::t('app', 'orders.labels.status'),
            Yii::t('app', 'orders.labels.mode'),
            Yii::t('app', 'orders.labels.created')
        ];

        $file = fopen('php://memory', 'wb');
        fputcsv($file, $columns);

        foreach ($query->asArray()->each(1000, UnbufferedConnection::getInstance()) as $data) {
            $service = $services[$data['service_id']];
            $raw = [
                $data['id'],
                $data['user']['first_name'] . ' ' . $data['user']['last_name'],
                $data['link'],
                $data['quantity'],
                $service['orders_count'] . ' ' . $service['name'],
                self::statuses()[$data['status']],
                self::modes()[$data['mode']],
                implode(' ', DateTimeTools::formatTimestamp($data['created_at'])),
            ];
            fputcsv($file, $raw);
        }

        return $file;
    }
}
