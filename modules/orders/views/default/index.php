<?php

use yii\bootstrap\ButtonDropdown;
use yii\grid\GridView;

use app\modules\orders\widgets\FilterAndSearchWidget;

use kartik\export\ExportMenu;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\orders\models\OrdersSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */


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
    'headerOptions'  => ['class' => 'dropdown-th'],
    'header' => ButtonDropdown::widget([
      'label'    => Yii::t('app', 'orders.labels.service'),
      'options'  => ['class' => 'btn btn-th btn-default dropdown-toggle'],
      'dropdown' => [
        'encodeLabels' => false,
        'items'        => $searchModel->getServicesFilterItems(),
      ],
    ])
  ],
  [
    'attribute' => 'status',
    'value'     => function ($order) {
      return $order->getStatusName();
    },
  ],
  [
    'attribute'    => 'mode',
    'value'        => function ($order) {
      return $order->getModeName();
    },
    'headerOptions' => ['class' => 'dropdown-th'],
    'header'        => ButtonDropdown::widget([
      'label'    => Yii::t('app', 'orders.labels.mode'),
      'options'  => ['class' => 'btn btn-th btn-default dropdown-toggle'],
      'dropdown' => ['items' => $searchModel->getModesFilterItems()],
    ])
  ],
  [
    'attribute' => 'created_at',
    'content'   => function ($order) {
      [$date, $time] = $order->getFormateCreatedAt();
      return '<span class="nowrap">' . $date . '</span>' .
        '<span class="nowrap">' . $time . '</span>';
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
  <?= FilterAndSearchWidget::widget(['model'  => $searchModel,]) ?>

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