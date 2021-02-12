<?php

namespace app\components;

use PDO;
use Yii;
use yii\db\Connection;


class UnbufferedConnection
{
    private static ?Connection $_instance = null;

    protected function __construct()
    {
        self::$_instance = new Connection([
            'dsn'      => Yii::$app->db->dsn,
            'username' => Yii::$app->db->username,
            'password' => Yii::$app->db->password,
            'charset'  => Yii::$app->db->charset,
        ]);
        self::$_instance->open();
        self::$_instance->pdo->setAttribute(
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,
            false
        );
    }

    protected function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): Connection
    {
        if (self::$_instance != null) {
            return self::$_instance;
        }

        return (new self)::$_instance;
    }

    protected function __destruct()
    {
        self::$_instance->close();
    }
}
