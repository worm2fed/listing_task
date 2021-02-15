<?php

use yii\grid\GridView;
use yii\helpers\Url;

use app\modules\orders\widgets\FilterAndSearchWidget;
use app\modules\orders\widgets\ModesFilterWidget;
use app\modules\orders\widgets\ServicesFilterWidget;
use app\modules\orders\widgets\SaveWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\orders\models\OrdersSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $services array */

$this->title = Yii::t('app', 'orders.title');
$gridColumns = [
    'id',
    [
        'attribute' => 'user',
        'value' => 'user.fullName'
    ],
    [
        'attribute' => 'link',
        'contentOptions' => ['class' => 'link']
    ],
    'quantity',
    [
        'attribute' => 'service',
        'content' => function ($order) use ($services) {
            $service = $services[$order->service_id];
            return '<span class="label-id">' . $service['orders_count'] . '</span> ' . $service['name'];
        },
        'contentOptions' => ['class' => 'service'],
        'headerOptions' => ['class' => 'dropdown-th'],
        'header' => ServicesFilterWidget::widget([
            'label' => Yii::t('app', 'orders.labels.service')
        ])
    ],
    [
        'attribute' => 'status',
        'value' => function ($order) {
            return $order->getStatusName();
        },
    ],
    [
        'attribute' => 'mode',
        'value' => function ($order) {
            return $order->getModeName();
        },
        'headerOptions' => ['class' => 'dropdown-th'],
        'header' => ModesFilterWidget::widget([
            'label' => Yii::t('app', 'orders.labels.mode')
        ])
    ],
    [
        'attribute' => 'created_at',
        'content' => function ($order) {
            $created = '';
            foreach ($order->getFormattedCreatedAt() as $element) {
                $created .= '<span class="nowrap">' . $element . '</span>';
            }
            return $created;
        }
    ],
];
?>

<div class="container-fluid">
    <?= FilterAndSearchWidget::widget([
        'model'  => $searchModel,
        'searchAction' => Url::toRoute(['/orders'])
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => '{items}
        <div class="row">
            <div class="col-sm-8">{pager}</div> 
            <div class="col-sm-4 pagination-counters">
                {summary}<br>' . SaveWidget::widget() . '
            </div>
        </div>',
        'summary' => '{begin} to {end} of {totalCount}',
        'filterPosition' => null,
        'columns' => $gridColumns,
        'tableOptions' => ['class' => 'table order-table'],
        'options' => ['tag' => null]
    ]); ?>

</div>