<?php

use yii\db\Migration;

/**
 * Class m190826_061244_alter_grievance_stat_table
 */
class m190826_061244_alter_grievance_stat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE `grievance_stat`   
                ADD COLUMN `type` ENUM('grievance','nsdl','amount','cdsl') NULL AFTER `media_id`;
        ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190826_061244_alter_grievance_stat_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190826_061244_alter_grievance_stat_table cannot be reverted.\n";

        return false;
    }
    */
}
