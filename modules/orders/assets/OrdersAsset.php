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
        'js/bootstrap.min.js',
        'js/jquery.min.js',
    ];
    
    public $css = [
        'css/bootstrap.min.css',
        'css/custom.css',
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
    ];

}