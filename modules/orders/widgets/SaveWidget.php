<?php

namespace app\modules\orders\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * This widgets generates menu for orders to filter orders statuses 
 * and searching
 */
class SaveWidget extends Widget
{
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return Html::a(
            Yii::t('app', 'orders.save'),
            array_merge(['/orders/export'], Yii::$app->request->get())
        );
    }
}
