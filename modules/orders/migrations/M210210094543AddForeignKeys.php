<?php

namespace app\modules\orders\migrations;

use yii\db\Migration;

/**
 * Class M210210094543AddForeignKeys
 */
class M210210094543AddForeignKeys extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // creates index for column `user_id`
        $this->createIndex(
            'idx-orders-user_id',
            'orders',
            'user_id'
        );

        // add foreign key for table `orders`
        $this->addForeignKey(
            'fk-post-user_id',
            'orders',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );

        // creates index for column `service_id`
        $this->createIndex(
            'idx-orders-service_id',
            'orders',
            'service_id'
        );

        // add foreign key for table `orders`
        $this->addForeignKey(
            'fk-orders-service_id',
            'orders',
            'service_id',
            'services',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `orders`
        $this->dropForeignKey(
            'fk-orders-user_id',
            'orders'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-orders-user_id',
            'orders'
        );

        // drops foreign key for table `orders`
        $this->dropForeignKey(
            'fk-orders-service_id',
            'orders'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-orders-service_id',
            'orders'
        );
    }
}
