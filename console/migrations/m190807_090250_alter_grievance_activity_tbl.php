<?php

use yii\db\Migration;

/**
 * Class m190807_090250_alter_grievance_activity_tbl
 */
class m190807_090250_alter_grievance_activity_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE  `grievance_activity_log`   
        ADD COLUMN `is_msg_sent` TINYINT(1) DEFAULT 0  NULL AFTER `created_on`;
            ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190807_090250_alter_grievance_activity_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190807_090250_alter_grievance_activity_tbl cannot be reverted.\n";

        return false;
    }
    */
}
