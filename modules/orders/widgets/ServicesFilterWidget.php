<?php

namespace app\modules\orders\widgets;

use Yii;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

use app\modules\orders\models\orders\Orders;
use app\modules\orders\models\services\Services;
use yii\base\Widget;

/**
 * This widgets generates dropdown button to filter services
 */
class ServicesFilterWidget extends Widget
{
    /**
     * @var string button label
     */
    public string $label;

    /**
     * @var array with all services and corresponding orders count
     */
    public array $services;

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
        return ButtonDropdown::widget([
            'label' => $this->label,
            'options' => ['class' => 'btn btn-th btn-default dropdown-toggle'],
            'dropdown' => [
                'encodeLabels' => false,
                'items' => $this->getServicesFilterItems(),
            ],
        ]);
    }

    /**
     * @return array with items for services filter
     */
    private function getServicesFilterItems(): array
    {
        $items = [
            [
                'label' => Yii::t('app', 'orders.services.all') .
                    ' (' . Orders::getTotalCount() . ')',
                'url' => Url::current(['service_id' => null]),
                'options' => [
                    'class' => Yii::$app->request->get('service_id') === null
                        ? 'active' : ''
                ]
            ]
        ];

        foreach ($this->services as $id => $service) {
            array_push($items, [
                'label' => '<span class="label-id">' .
                    $service['orders_count'] . '</span> ' . $service['name'],
                'url' => Url::current(['service_id' => $id]),
                'options' => [
                    'class' => Yii::$app->request->get('service_id') === strval($id)
                        ? 'active' : ''
                ]
            ]);
        }
        ArrayHelper::multisort($items, 'count', SORT_DESC);

        return $items;
    }
}
