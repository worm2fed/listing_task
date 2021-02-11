<?php

use yii\bootstrap\ButtonDropdown;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Menu;

use app\modules\orders\models\orders\Orders;
use app\modules\orders\components\SearchWidget;

use kartik\export\ExportMenu;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\orders\models\OrdersSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $statuses_filter_items array */
/* @var $services_filter_items array */
/* @var $modes_filter_items array */


$this->title = Yii::t('app', 'orders.title');
$grid_columns = [
  'id',
  [
    'attribute' => 'user',
    'value'     => 'user.full_name'
  ],
  [
    'attribute'      => 'link',
    'contentOptions' => ['class' => 'link']
  ],
  'quantity',
  [
    'attribute' => 'service',
    'content'   => function ($order) {
      $service = $order->service;
      return '<span class="label-id">' . $service->orders_count . '</span> ' . $service->name;
    },
    'contentOptions' => ['class' => 'service'],
    'headerOptions' => ['class' => 'dropdown-th'],
    'header' => ButtonDropdown::widget([
      'label'    => Orders::instance()->getAttributeLabel('service'),
      'options'  => ['class' => 'btn btn-th btn-default dropdown-toggle'],
      'dropdown' => [
        'encodeLabels' => false,
        'items'        => $services_filter_items,
      ],
    ])
  ],
  [
    'attribute' => 'status',
    'value'     => function ($order) {
      return Orders::statuses()[$order->status];
    },
  ],
  [
    'attribute'    => 'mode',
    'value'        => function ($order) {
      return Orders::modes()[$order->mode];
    },
    'headerOptions' => ['class' => 'dropdown-th'],
    'header'        => ButtonDropdown::widget([
      'label'    => Orders::instance()->getAttributeLabel('mode'),
      'options'  => ['class' => 'btn btn-th btn-default dropdown-toggle'],
      'dropdown' => ['items' => $modes_filter_items],
    ])
  ],
  [
    'attribute' => 'created_at',
    'content'   => function ($order) {
      $dt = new DateTime();
      $dt->setTimestamp($order->created_at);
      return '<span class="nowrap">' . $dt->format('Y-m-d') . '</span>' .
        '<span class="nowrap">' . $dt->format('H:m:s') . '</span>';
    }
  ],
];
$export_widget = ExportMenu::widget([
  'dataProvider'     => $dataProvider,
  'columns'          => $grid_columns,
  'target'           => ExportMenu::TARGET_BLANK,
  'asDropdown'       => false,
  'showConfirmAlert' => false,
  'filename'         => 'orders-export',
  'exportConfig'     => [
    ExportMenu::FORMAT_HTML     => false,
    ExportMenu::FORMAT_TEXT     => false,
    ExportMenu::FORMAT_PDF      => false,
    ExportMenu::FORMAT_EXCEL    => false,
    ExportMenu::FORMAT_EXCEL_X  => false,
    ExportMenu::FORMAT_CSV      => [
      'label'     => Yii::t('app', 'orders.save'),
      'icon'      => null,
      'mime'      => 'application/csv',
      'extension' => 'csv',
      'writer'    => ExportMenu::FORMAT_CSV,
      'options'   => [
        'title' => null,
        'tag'   => 'span',
        'class' => 'pull-right'
      ]
    ]
  ],
]);
?>

<div class="container-fluid">
  <?= Menu::widget([
    'options' => ['class' => 'nav nav-tabs p-b'],
    'items'   => array_merge(
      $statuses_filter_items,
      [[
        'label'    => SearchWidget::widget([
          'model'  => $searchModel,
          'action' => Url::toRoute(['/orders']),
          'method' => 'get',
        ]),
        'options'  => ['class' => 'pull-right custom-search'],
        'template' => '{label}',
        'encode'   => false
      ]]
    )
  ]) ?>

  <?= GridView::widget([
    'dataProvider'   => $dataProvider,
    'filterModel'    => $searchModel,
    'layout'         => '{items}
      <div class="row">
        <div class="col-sm-8">{pager}</div> 
        <div class="col-sm-4 pagination-counters">
          {summary}<br>' . $export_widget . '
        </div>
      </div>',
    'summary'        => '{begin} to {end} of {totalCount}',
    'filterPosition' => null,
    'columns'        => $grid_columns,
    'tableOptions'   => ['class' => 'table order-table']
  ]); ?>

</div>