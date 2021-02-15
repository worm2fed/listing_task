<?php

namespace app\modules\orders\models\services;

use Yii;

use app\modules\orders\models\orders\Orders;

/**
 * This is the model class for table "services".
 *
 * @property int $id
 * @property string $name
 */
class Services extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'services';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'orders.labels.id'),
            'name' => Yii::t('app', 'orders.labels.name'),
        ];
    }

    /**
     * {@inheritdoc}
     * 
     * @return ServicesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ServicesQuery(get_called_class());
    }

    /**
     * @return Orders all orders according to current service
     */
    public function getOrders()
    {
        return $this->hasMany(
            Orders::class,
            ['service_id' => 'id']
        )->inverseOf('service');
    }

    /**
     * @return int counts orders according to current service
     */
    public function getOrdersCount()
    {
        return (int) Orders::find()
            ->where(['service_id' => $this->id])
            ->count();
    }

    /**
     * Get all services in array
     * 
     * @param string $asArray, default is true, whether return content as 
     *     array or string
     * 
     * @return array which have ids as keys 
     * and stores only name and orders count
     */
    public static function getServicesArray(bool $asArray = true): array
    {
        $services = [];
        foreach (self::find()->all() as $service) {
            if ($asArray) {
                $services[$service->id] = [
                    'orders_count' => $service->ordersCount,
                    'name' => $service->name
                ];
            } else {
                $services[$service->id] =
                    '(' . $service->ordersCount . ') ' . $service->name;
            }
        }
        return $services;
    }
}
