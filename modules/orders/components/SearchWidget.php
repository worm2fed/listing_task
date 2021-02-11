<?php

namespace app\modules\orders\components;

use yii\base\Widget;


/**
 * This widgets generates search form for orders
 */
class SearchWidget extends Widget
{
    /**
     * @var app\modules\orders\models\OrdersSearch
     */
    public $model;
    /**
     * @var string
     */
    public $action;
    /**
     * @var string
     */
    public $method;

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
        return $this->render('_search', [
            'model'  => $this->model,
            'action' => $this->action,
            'method' => $this->method,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getViewPath()
    {
        return '@app/modules/orders/views/search/';
    }
}
