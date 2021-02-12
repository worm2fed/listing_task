<?php

$db = require __DIR__ . '/local/db.php';

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
    'username' => DB_USER,
    'password' => DB_PASSWORD,
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 600,
    'schemaCache' => 'cache',
    'enableQueryCache' => true,
    'queryCacheDuration' => 3600,
];
