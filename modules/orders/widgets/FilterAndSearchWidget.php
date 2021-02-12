<?php

namespace app\modules\orders\widgets;

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
            'model'  => $this->model
        ]);
    }
}
