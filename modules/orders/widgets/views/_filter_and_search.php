<?php

use yii\helpers\Url;
use yii\widgets\Menu;

use app\modules\orders\widgets\SearchWidget;

/* @var $this yii\web\View */
/* @var $model app\modules\orders\models\OrdersSearch */
?>

<?= Menu::widget([
    'options' => ['class' => 'nav nav-tabs p-b'],
    'items' => array_merge(
        $model->getStatusesFilterItems(),
        [[
            'label' => SearchWidget::widget([
                'model' => $model,
                'action' => Url::toRoute(['/orders']),
                'method' => 'get',
            ]),
            'options' => ['class' => 'pull-right custom-search'],
            'template' => '{label}',
            'encode' => false
        ]]
    )
]) ?>