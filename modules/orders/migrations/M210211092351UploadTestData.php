<?php

namespace app\modules\orders\migrations;

use Yii;
use yii\db\Migration;

/**
 * Class M210211092351UploadTestData
 */
class M210211092351UploadTestData extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = file_get_contents(__DIR__ . '/sql/test_db_data.sql');

        $command = Yii::$app->db->createCommand($sql);
        $command->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $sql = <<<SQL
        TRUNCATE TABLE `orders`;
        TRUNCATE TABLE `services`;
        TRUNCATE TABLE `users`;
        SQL;

        $command = Yii::$app->db->createCommand($sql);
        $command->execute();
    }
}
