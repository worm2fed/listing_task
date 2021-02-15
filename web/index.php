<?php

require __DIR__ . '/../vendor/autoload.php';

$config = new codemix\yii2confload\Config(__DIR__ . '/..');

require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

(new yii\web\Application($config->web()))->run();
