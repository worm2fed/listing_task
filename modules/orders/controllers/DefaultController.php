<?php

namespace app\modules\orders\controllers;

use yii\web\Controller;


class DefaultController extends Controller
{
    public $layout = 'main';

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}