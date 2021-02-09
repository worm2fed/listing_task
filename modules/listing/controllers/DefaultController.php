<?php

namespace app\modules\listing\controllers;

use Yii;
use yii\web\Controller;

use app\modules\listing\models\orders\OrdersSearch;


class DefaultController extends Controller
{
    public $layout = 'main';

    /**
     * Lists all Orders models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}