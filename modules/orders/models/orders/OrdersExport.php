<?php

namespace app\modules\orders\models\orders;

use Yii;

use app\components\DateTimeTools;
use app\components\UnbufferedConnection;
use app\modules\orders\models\services\Services;

/**
 * OrdersSearch represents the model to export Orders
 */
class OrdersExport extends OrdersSearch
{
    /**
     * Method to export orders to csv with filters applied
     * 
     * @param OrdersQuery $query to find orders
     * 
     * @return resource|false 
     */
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
                self::getStatuses()[$data['status']],
                self::getModes()[$data['mode']],
                implode(' ', DateTimeTools::formatTimestamp($data['created_at'])),
            ];
            fputcsv($file, $raw);
        }

        return $file;
    }
}
