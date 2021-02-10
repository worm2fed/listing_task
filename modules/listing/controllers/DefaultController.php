<?php

namespace app\modules\listing\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
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
      'services_filter_items' => $this->getServicesFilterItems(),
      'statuses_filter_items' => $this->getStatusesFilterItems(),
      'modes_filter_items'    => $this->getModesFilterItems(),
    ]);
  }

  /**
   * @return array
   */
  private function getStatusesFilterItems()
  {
    $statuses_filter_items = [
      [
        'label'  => Yii::t('listing', 'All orders'),
        'url'    => Url::current([
          'status'     => null,
          'mode'       => null,
          'service_id' => null
        ]),
        'active' => is_null(Yii::$app->request->get('status'))
      ]
    ];
    foreach (Orders::statuses() as $key => $value) {
      array_push($statuses_filter_items, [
        'label'  => $value,
        'url'    => Url::current([
          'status'     => $key,
          'mode'       => null,
          'service_id' => null
        ]),
        'active' => Yii::$app->request->get('status') === strval($key)
      ]);
    }
    return $statuses_filter_items;
  }

  /**
   * @return array
   */
  private function getServicesFilterItems()
  {
    $services_filter_items = [
      [
        'label'   => Yii::t('listing', 'All') . ' (' . Orders::getTotal_count() . ')',
        'url'     => Url::current(['service_id' => null]),
        'options' => [
          'class' => is_null(Yii::$app->request->get('service_id'))
            ? 'active'
            : ''
        ]
      ]
    ];
    foreach (Services::find()->all() as $item) {
      array_push($services_filter_items, [
        'label'   => '<span class="label-id">' . $item->orders_count . '</span> ' . $item->name,
        'url'     => Url::current(['service_id' => $item->id]),
        'options' => [
          'class' => Yii::$app->request->get('service_id') === strval($item->id)
            ? 'active'
            : ''
        ]
      ]);
    }
    ArrayHelper::multisort($services_filter_items, 'count', SORT_DESC);
    return $services_filter_items;
  }

  /**
   * @return array
   */
  private function getModesFilterItems()
  {
    return [
      [
        'label'  => Yii::t('listing', 'All'),
        'url'    => Url::current(['mode' => null]),
        'options' => [
          'class' => is_null(Yii::$app->request->get('mode'))
            ? 'active'
            : ''
        ]
      ],
      [
        'label'  => Yii::t('listing', 'Manual'),
        'url'    => Url::current(['mode' => 0]),
        'options' => [
          'class' => Yii::$app->request->get('mode') === strval(0)
            ? 'active'
            : ''
        ]
      ],
      [
        'label'  => Yii::t('listing', 'Auto'),
        'url'    => Url::current(['mode' => 1]),
        'options' => [
          'class' => Yii::$app->request->get('mode') === strval(1)
            ? 'active'
            : ''
        ]
      ],
    ];
  }
}
