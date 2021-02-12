<?php

namespace app\modules\orders\widgets;

use yii\base\Widget;

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
        return $this->render('_save');
    }
}
