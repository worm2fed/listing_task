<?php

namespace app\modules\listing\assets;

use yii\web\AssetBundle;   


class ListingAsset extends AssetBundle 
{
    public $sourcePath = '@app/modules/listing/assets';

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