<?php

namespace app\modules\orders\controllers;

use Yii;
use yii\web\Controller;

use app\modules\orders\models\orders\OrdersSearch;
use app\modules\orders\models\services\Services;

/**
 * This controller defines actions to list, filter and export orders
 */
class OrdersController extends Controller
{
    public $layout = 'main';

    /**
     * Lists all Orders models (with filters applied)
     * 
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'services'     => Services::getServicesArray()
        ]);
    }

    /**
     * Exports all Orders models (with filters applied)
     * 
     * @return mixed
     */
    public function actionExport()
    {
        $searchModel = new OrdersSearch();
        $query = $searchModel->buildQuery(
            Yii::$app->request->queryParams
        );

        return Yii::$app->response->sendStreamAsFile(
            $searchModel::export($query),
            'orders_' . time() . '.csv',
            ['mimeType' => 'text/csv']
        );
    }
}
