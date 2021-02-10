<?php

namespace app\modules\listing\assets;

use yii\web\AssetBundle;


class ListingAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@app/modules/listing/assets';

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
