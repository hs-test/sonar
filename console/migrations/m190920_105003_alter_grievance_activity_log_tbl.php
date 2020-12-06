<?php

use yii\db\Migration;

/**
 * Class m190920_105003_alter_grievance_activity_log_tbl
 */
class m190920_105003_alter_grievance_activity_log_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE `grievance_activity_log`   
        CHANGE `additional_comment` `additional_comment` TEXT CHARSET latin1 COLLATE latin1_swedish_ci NULL;
    ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190920_105003_alter_grievance_activity_log_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190920_105003_alter_grievance_activity_log_tbl cannot be reverted.\n";

        return false;
    }
    */
}
