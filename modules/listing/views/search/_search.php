<?php

use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $action string */
/* @var $method string */
/* @var $model app\modules\orders\models\OrdersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
  'action'  => $action,
  'method'  => $method,
  'options' => ['class' => 'form-inline']
]); ?>

<div class="input-group">
  <?= Html::textInput(
    'search',
    Yii::$app->request->get('search'),
    [
      'class' => 'form-control',
      'placeholder' => Yii::t('listing', 'Search orders')
    ]
  ) ?>

  <?= Html::hiddenInput('status', Yii::$app->request->get('status')) ?>

  <span class="input-group-btn search-select-wrap">
    <?= Html::dropDownList(
      'search_type',
      Yii::$app->request->get('search_type'),
      [
        1 => Yii::t('listing', 'Order ID'),
        2 => Yii::t('listing', 'Link'),
        3 => Yii::t('listing', 'Username'),
      ],
      ['class' => 'form-control search-select']
    ) ?>

    <?= Html::submitButton(
      Html::tag('span', '', [
        'class' => 'glyphicon glyphicon-search',
        'aria-hidden' => 'true'
      ]),
      ['class' => 'btn btn-default']
    )
    ?>
  </span>
</div>

<?php ActiveForm::end(); ?>