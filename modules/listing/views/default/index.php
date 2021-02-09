<?php

use yii\bootstrap\ButtonDropdown;
use yii\grid\GridView;

use app\modules\listing\models\orders\Orders;


$this->title = Yii::t('listing', 'Orders');
?>

<div class="container-fluid">
  <?= ""#$this->render('_search', ['model' => $searchModel]) ?>

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
        'content' => function($order) {
          $service = $order->service;
          return '<span class="label-id">' . '1' . '</span> ' . $service->name;
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
            'items' => [
                ['label' => 'All (894931)', 'encode' => false, 'url' => '#'],
                ['label' => '<span class="label-id">214</span> Real Views', 'encode' => false, 'url' => '/'],
                ['label' => '<span class="label-id">215</span> Page Likes', 'encode' => false, 'url' => '/'],
                ['label' => '<span class="label-id">10</span> Page Likes', 'encode' => false, 'url' => '/'],
                ['label' => '<span class="label-id">217</span> Page Likes', 'encode' => false, 'url' => '/'],
                ['label' => '<span class="label-id">221</span> Followers', 'encode' => false, 'url' => '/'],
                ['label' => '<span class="label-id">224</span> Groups Join', 'encode' => false, 'url' => '/'],
                ['label' => '<span class="label-id">230</span> Website Likes', 'encode' => false, 'url' => '/'],
            ],
          ],
        ])
      ],
      [
        'attribute' => 'status',
        'value' => function($order) {
          return Orders::statuses()[$order->status];
        },
      ],
      [
        'attribute' => 'mode',
        'value' => function($order) {
          return Orders::modes()[$order->mode];
        },
        'headerOptions' => [
          'class' => 'dropdown-th'
        ],
        'header' => ButtonDropdown::widget([
          'label' => Orders::instance()->getAttributeLabel('mode'),
          'options' => ['class' => 'btn btn-th btn-default dropdown-toggle'],
          'dropdown' => [
            'items' => [
                ['label' => 'All', 'url' => '#'],
                ['label' => 'Manual', 'url' => '/'],
                ['label' => 'Auto', 'url' => '/'],
            ],
          ],
        ])
      ],
      [
        'attribute' => 'created_at',
        'content' => function($order) {
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
