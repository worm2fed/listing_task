<?php

namespace app\modules\orders\assets;

use yii\web\AssetBundle;   


class OrdersAsset extends AssetBundle 
{
    public $sourcePath = '@app/modules/orders/assets';

    public function init()
    {
        $this->sourcePath = __DIR__;
        parent::init();
    }
    
    public $js = [
    ];
    
    public $css = [
        'css/custom.css',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

}