<?php

namespace app\modules\orders\migrations;

use Yii;
use yii\db\Migration;

/**
 * Class M210211092418AddForeignKeys
 */
class M210211092418AddForeignKeys extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = <<<SQL
        CREATE INDEX `idx-orders-user_id` ON orders(user_id);
        ALTER TABLE orders 
            ADD CONSTRAINT `fk-orders-user_id`
            ADD FOREIGN KEY (user_id) REFERENCES users(id);

        CREATE INDEX `idx-orders-service_id` ON orders(service_id);
        ALTER TABLE orders 
            ADD CONSTRAINT `fk-orders-service_id`
            ADD FOREIGN KEY (service_id) REFERENCES services(id);
        SQL;

        $command = Yii::$app->db->createCommand($sql);
        $command->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $sql = <<<SQL
        DROP INDEX `idx-orders-user_id` ON orders;
        ALTER TABLE orders 
            DROP FOREIGN KEY `fk-orders-user_id`;

        DROP INDEX `idx-orders-service_id` ON orders;
        ALTER TABLE orders 
            DROP FOREIGN KEY `fk-orders-service_id`;
        SQL;

        $command = Yii::$app->db->createCommand($sql);
        $command->execute();
    }
}
