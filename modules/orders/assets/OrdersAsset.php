<?php

namespace app\modules\orders\assets;

use yii\web\AssetBundle;

class OrdersAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/modules/orders/assets';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->sourcePath = __DIR__;
        parent::init();
    }

    /**
     * @var array
     */
    public $js = [];

    /**
     * @var array
     */
    public $css = [
        'css/custom.css',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
