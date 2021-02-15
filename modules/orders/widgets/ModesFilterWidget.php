<?php

namespace app\modules\orders\widgets;

use Yii;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;

use app\modules\orders\models\orders\Orders;
use yii\base\Widget;

/**
 * This widgets generates dropdown button to filter modes
 */
class ModesFilterWidget extends Widget
{
    /**
     * @var string button label
     */
    public $label;

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
                'items' => $this->getModesFilterItems()
            ],
        ]);
    }

    /**
     * @return array with modes for statuses filter
     */
    public function getModesFilterItems(): array
    {
        $items = [
            [
                'label' => Yii::t('app', 'orders.modes.all'),
                'url' => Url::current(['mode' => null]),
                'options' => [
                    'class' => Yii::$app->request->get('mode') === null
                        ? 'active' : ''
                ]
            ]
        ];

        foreach (Orders::getModes() as $key => $value) {
            array_push($items, [
                'label' => $value,
                'url' => Url::current(['mode' => $key]),
                'options' => [
                    'class' => Yii::$app->request->get('mode') === strval($key)
                        ? 'active' : ''
                ]
            ]);
        }

        return $items;
    }
}
