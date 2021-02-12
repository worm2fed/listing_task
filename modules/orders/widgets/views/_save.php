<?php

use yii\helpers\Html;

?>

<?= Html::a(
    Yii::t('app', 'orders.save'),
    array_merge(['/orders/export'], Yii::$app->request->get())
) ?>