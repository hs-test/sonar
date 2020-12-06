<?php

use yii\db\Migration;

/**
 * Class m190822_095934_alter_grievance_table
 */
class m190822_095934_alter_grievance_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE `grievance` ADD COLUMN `pay_status` TINYINT(1) NULL AFTER `status`;")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190822_095934_alter_grievance_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190822_095934_alter_grievance_table cannot be reverted.\n";

        return false;
    }
    */
}
