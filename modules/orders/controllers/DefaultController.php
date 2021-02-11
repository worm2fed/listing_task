<?php

namespace app\modules\orders\controllers;

use Yii;
use yii\web\Controller;

use app\modules\orders\models\orders\OrdersSearch;


class DefaultController extends Controller
{
  public $layout = 'main';

  /**
   * Lists all Orders models (with filters applied).
   * @return mixed
   */
  public function actionIndex()
  {
    $searchModel = new OrdersSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
      'searchModel'  => $searchModel,
      'dataProvider' => $dataProvider
    ]);
  }
}
