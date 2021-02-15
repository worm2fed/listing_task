<?php

/* @var codemix\yii2confload\Config $this */

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=' . self::env('DB_HOST', 'localhost') . ';' .
        'dbname=' . self::env('DB_NAME', 'listing_task'),
    'username' => self::env('DB_USER', 'listing_task'),
    'password' => self::env('DB_PASSWORD', 'listing_task'),
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 600,
    'schemaCache' => 'cache',
    'enableQueryCache' => true,
    'queryCacheDuration' => 3600,
];
