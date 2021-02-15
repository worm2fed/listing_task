<?php

namespace app\components;

use PDO;
use Exception;
use Yii;
use yii\db\Connection;

/**
 * This class provides interface to communicate with database via unbuffered
 * connection
 */
class UnbufferedConnection
{
    /**
     * @var Connection|null $connection stores connection to database 
     */
    private static ?Connection $connection = null;

    /**
     * This constructor creates unbuffered connection to database
     */
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

    /**
     * We do not allow to clone instances because of this class designed 
     * according to singleton pattern
     */
    protected function __clone()
    {
    }

    /**
     * We do not allow to unserialize instances because of this class designed 
     * according to singleton pattern
     */
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize a singleton");
    }

    /**
     * Method to get connection
     * 
     * @return Connection
     */
    public static function getInstance(): Connection
    {
        if (self::$connection != null) {
            return self::$connection;
        }

        return (new self)::$connection;
    }

    /**
     * When we do not need connection any more we have to close it
     */
    protected function __destruct()
    {
        self::$connection->close();
    }
}
