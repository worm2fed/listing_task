<?php

use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use yii\helpers\Html;

use app\modules\orders\assets\OrdersAsset;


OrdersAsset::register($this);

/* @var $this yii\web\View */
/* @var $content string */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?= Html::csrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <style>
    .label-default {
      border: 1px solid #ddd;
      background: none;
      color: #333;
      min-width: 30px;
      display: inline-block;
    }
  </style>
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <?php $this->head() ?>
</head>

<body>
  <?php $this->beginBody() ?>

  <?php NavBar::begin([
    'options'               => ['class' => 'navbar navbar-fixed-top navbar-default'],
    'innerContainerOptions' => ['class' => 'container-fluid'],
  ]) ?>

  <?= Nav::widget([
    'items'   => [
      [
        'label'  => Yii::t('app', 'orders.title'),
        'url'    => ['/orders'],
        'active' => Yii::$app->controller->id == 'default'
      ],
    ],
    'options' => ['class' => 'navbar-nav'],
  ]) ?>

  <?php NavBar::end() ?>

  <?= $content ?>

  <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>