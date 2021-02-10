<?php

namespace app\modules\listing\components;

use yii\base\Widget;


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
        return '@app/modules/listing/views/search/';
    }
}
