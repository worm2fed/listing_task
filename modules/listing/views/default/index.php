<?php

use yii\bootstrap\ButtonDropdown;
use yii\grid\GridView;
use yii\widgets\Menu;

use app\modules\listing\models\orders\Orders;
use app\modules\listing\components\SearchWidget;


$this->title = Yii::t('listing', 'Orders');
?>

<div class="container-fluid">
  <?= Menu::widget([
    'options' => ['class' => 'nav nav-tabs p-b'],
    'items' => array_merge(
      $statuses_filter_items,
      [[
        'label' => SearchWidget::widget([
          'model'  => $searchModel,
          'action' => 'listing',
          'method' => 'get',
        ]),
        'options' => ['class' => 'pull-right custom-search'],
        'template' => '{label}',
        'encode'  => false
      ]]
    )
  ]) ?>

  <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'layout' => '{items}
      <div class="row">
        <div class="col-sm-8">{pager}</div> 
        <div class="col-sm-4 pagination-counters">{summary}</div>
      </div>',
    'summary' => '{begin} to {end} of {totalCount}',
    'filterPosition' => null,
    'columns' => [
      'id',
      [
        'attribute' => 'user',
        'value' => 'user.full_name'
      ],
      [
        'attribute' => 'link',
        'contentOptions' => [
          'class' => 'link',
        ]
      ],
      'quantity',
      [
        'attribute' => 'service',
        'content' => function ($order) {
          $service = $order->service;
          return '<span class="label-id">' . $service->orders_count . '</span> ' . $service->name;
        },
        'contentOptions' => [
          'class' => 'service',
        ],
        'headerOptions' => [
          'class' => 'dropdown-th'
        ],
        'header' => ButtonDropdown::widget([
          'label' => Orders::instance()->getAttributeLabel('service'),
          'options' => ['class' => 'btn btn-th btn-default dropdown-toggle'],
          'dropdown' => [
            'encodeLabels' => false,
            'items' => $services_filter_items,
          ],
        ])
      ],
      [
        'attribute' => 'status',
        'value' => function ($order) {
          return Orders::statuses()[$order->status];
        },
      ],
      [
        'attribute' => 'mode',
        'value' => function ($order) {
          return Orders::modes()[$order->mode];
        },
        'headerOptions' => [
          'class' => 'dropdown-th'
        ],
        'header' => ButtonDropdown::widget([
          'label' => Orders::instance()->getAttributeLabel('mode'),
          'options' => ['class' => 'btn btn-th btn-default dropdown-toggle'],
          'dropdown' => [
            'items' => $modes_filter_items,
          ],
        ])
      ],
      [
        'attribute' => 'created_at',
        'content' => function ($order) {
          $dt = new DateTime();
          $dt->setTimestamp($order->created_at);
          return '<span class="nowrap">' . $dt->format('Y-m-d') . '</span>' .
            '<span class="nowrap">' . $dt->format('H:m:s') . '</span>';
        }
      ],
    ],
    'tableOptions' => [
      'class' => 'table order-table'
    ],

  ]); ?>
</div>