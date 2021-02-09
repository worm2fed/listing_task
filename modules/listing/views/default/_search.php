<?php

use yii\bootstrap\Nav;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\modules\listing\models\orders\Orders;

/* @var $this yii\web\View */
/* @var $model app\modules\orders\models\OrdersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<?= Nav::widget([
  'route' => 'listing',
  'items' => [
    [
      'label' => 'All orders',
      'url' => ['/listing'],
      'linkOptions' => [],
    ],

    // [
    //   'label' => 'Dropdown',
    //   'items' => [
    //     ['label' => 'Level 1 - Dropdown A', 'url' => '#'],
    //     '<li class="divider"></li>',
    //     '<li class="dropdown-header">Dropdown Header</li>',
    //     ['label' => 'Level 1 - Dropdown B', 'url' => '#'],
    //   ],
    // ],
  ],
  'options' => ['class' =>'nav nav-tabs p-b'],
]) ?>


<!-- <ul class="nav nav-tabs p-b">
  <li class="active"><a href="#">All orders</a></li>
  <li><a href="#">Pending</a></li>
  <li><a href="#">In progress</a></li>
  <li><a href="#">Completed</a></li>
  <li><a href="#">Canceled</a></li>
  <li><a href="#">Error</a></li>
  <li class="pull-right custom-search">

    <form class="form-inline" action="/admin/orders" method="get">
      <div class="input-group">
        <input type="text" name="search" class="form-control" value="" placeholder="Search orders">
        <span class="input-group-btn search-select-wrap">

          <select class="form-control search-select" name="search-type">
            <option value="1" selected="">Order ID</option>
            <option value="2">Link</option>
            <option value="3">Username</option>
          </select>
          <button type="submit" class="btn btn-default">
            <span class="glyphicon glyphicon-search"
              aria-hidden="true"></span>
          </button>
        </span>
      </div>
    </form>

  </li>
</ul> -->


<!-- <div class="orders-search">

  <?php $form = ActiveForm::begin([
        'action' => ['listing'],
        'method' => 'get',
    ]); ?>

  <?= $form->field($model, 'id') ?>

  <div class="form-group">
    <?= Html::submitButton(Yii::t('listing', 'Search'), ['class' => 'btn btn-primary']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div> -->