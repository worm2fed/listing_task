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
            'id'   => Yii::t('app', 'orders.labels.id'),
            'name' => Yii::t('app', 'orders.labels.name'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ServicesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ServicesQuery(get_called_class());
    }

    public function getOrders()
    {
        return $this->hasMany(
            Orders::class,
            ['service_id' => 'id']
        )->inverseOf('service');
    }

    /**
     * @return int|string
     */
    public function getOrders_count()
    {
        return Orders::find()->where(['service_id' => $this->id])->count();
    }

    public static function getServicesArray()
    {
        $services = [];
        foreach (self::find()->all() as $service) {
            $services[$service->id] = [
                'orders_count' => $service->orders_count,
                'name' => $service->name
            ];
        }
        return $services;
    }
}
