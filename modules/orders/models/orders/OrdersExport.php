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
    public function export(OrdersQuery $query)
    {
        $services = Services::getServicesArray(false);
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

        foreach ($query->asArray()->each(1000, UnbufferedConnection::getConnection()) as $data) {
            $raw = [
                $data['id'],
                $data['full_name'],
                $data['link'],
                $data['quantity'],
                $services[$data['service_id']],
                self::getStatuses()[$data['status']],
                self::getModes()[$data['mode']],
                DateTimeTools::formatTimestamp($data['created_at'], false)
            ];
            fputcsv($file, $raw);
        }

        return $file;
    }
}
