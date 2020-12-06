<?php

use yii\db\Migration;

/**
 * Class m190810_073412_alter_grievance_activity_tbl
 */
class m190810_073412_alter_grievance_activity_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE  `grievance_activity_log`   
            ADD COLUMN `additional_comment` VARCHAR(255) NULL AFTER `comments`;
        ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190810_073412_alter_grievance_activity_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190810_073412_alter_grievance_activity_tbl cannot be reverted.\n";

        return false;
    }
    */
}
