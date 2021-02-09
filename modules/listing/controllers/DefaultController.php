<?php

namespace app\modules\listing\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

use app\modules\listing\models\services\Services;
use app\modules\listing\models\orders\Orders;
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
      'services_filter_items' => $this->getServicesItems()
    ]);
  }

  private function getServicesItems()
  {
    $services_filter_items = [
      [
        'label' => 'All (' . Orders::getTotal_count() . ')',
        'url' => '',
      ]
    ];
    foreach (Services::find()->all() as $item) {
      array_push($services_filter_items, [
        'label' => '<span class="label-id">' . $item->orders_count . '</span> ' . $item->name,
        'url'   => '',
      ]);
    }
    ArrayHelper::multisort($services_filter_items, 'count', SORT_DESC);
    return $services_filter_items;
  }
}
