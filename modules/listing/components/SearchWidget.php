<?php

namespace app\modules\listing\components;

use yii\base\Widget;


class SearchWidget extends Widget
{
    public $model;
    public $action;
    public $method;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('_search', [
            'model'  => $this->model,
            'action' => $this->action,
            'method' => $this->method,
        ]);
    }

    public function getViewPath()
    {
        return '@app/modules/listing/views/search/';
    }
}
