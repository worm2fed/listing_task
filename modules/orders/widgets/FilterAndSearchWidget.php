<?php

namespace app\modules\orders\widgets;

use Yii;
use yii\helpers\Url;

use app\modules\orders\models\orders\Orders;
use yii\base\Widget;

/**
 * This widgets generates menu for orders to filter orders statuses 
 * and searching
 */
class FilterAndSearchWidget extends Widget
{
    /**
     * @var app\modules\orders\models\OrdersSearch
     */
    public $model;

    /**
     * @var string action url for searching
     */
    public $searchAction;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return $this->render('_filter_and_search', [
            'model' => $this->model,
            'searchAction' => $this->searchAction,
            'statusesFilterItems' => $this->getStatusesFilterItems()
        ]);
    }

    /**
     * @return array with items for statuses filter
     */
    private function getStatusesFilterItems(): array
    {
        $items = [
            [
                'label' => Yii::t('app', 'orders.statuses.all'),
                'url' => Url::current([
                    'status' => null,
                    'mode' => null,
                    'service_id' => null
                ]),
                'active' => Yii::$app->request->get('status') === null
            ]
        ];

        foreach (Orders::getStatuses() as $key => $value) {
            array_push($items, [
                'label' => $value,
                'url' => Url::current([
                    'status' => $key,
                    'mode' => null,
                    'service_id' => null
                ]),
                'active' => Yii::$app->request->get('status') === strval($key)
            ]);
        }

        return $items;
    }
}
