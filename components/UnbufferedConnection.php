<?php

namespace app\components;

use PDO;
use Exception;
use Yii;
use yii\db\Connection;

class UnbufferedConnection
{
    private static ?Connection $connection = null;

    protected function __construct()
    {
        self::$connection = new Connection([
            'dsn'      => Yii::$app->db->dsn,
            'username' => Yii::$app->db->username,
            'password' => Yii::$app->db->password,
            'charset'  => Yii::$app->db->charset,
        ]);
        self::$connection->open();
        self::$connection->pdo->setAttribute(
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,
            false
        );
    }

    protected function __clone()
    {
    }

    public function __wakeup()
    {
        throw new Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): Connection
    {
        if (self::$connection != null) {
            return self::$connection;
        }

        return (new self)::$connection;
    }

    protected function __destruct()
    {
        self::$connection->close();
    }
}
