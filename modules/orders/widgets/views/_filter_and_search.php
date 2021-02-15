<?php

use yii\widgets\Menu;

use app\modules\orders\widgets\SearchWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\orders\models\OrdersSearch */
/* @var $searchAction string */
/* @var $statusesFilterItems array */
?>

<?= Menu::widget([
    'options' => ['class' => 'nav nav-tabs p-b'],
    'items' => array_merge(
        $statusesFilterItems,
        [[
            'label' => SearchWidget::widget([
                'model' => $model,
                'action' => $searchAction,
                'method' => 'get',
            ]),
            'options' => ['class' => 'pull-right custom-search'],
            'template' => '{label}',
            'encode' => false
        ]]
    )
]) ?>