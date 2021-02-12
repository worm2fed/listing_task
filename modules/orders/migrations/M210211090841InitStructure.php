<?php

namespace app\modules\orders\migrations;

use Yii;
use yii\db\Migration;

/**
 * Class M210211090841InitStructure
 */
class M210211090841InitStructure extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = file_get_contents(__DIR__ . '/sql/test_db_structure.sql');

        $command = Yii::$app->db->createCommand($sql);
        $command->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $sql = <<<SQL
        SET FOREIGN_KEY_CHECKS = 0;
        DROP TABLE IF EXISTS `orders`;
        DROP TABLE IF EXISTS `services`;
        DROP TABLE IF EXISTS `users`;
        SET FOREIGN_KEY_CHECKS = 1;
        SQL;

        $command = Yii::$app->db->createCommand($sql);
        $command->execute();
    }
}
