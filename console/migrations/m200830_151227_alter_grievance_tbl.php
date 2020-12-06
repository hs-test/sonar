<?php

use yii\db\Migration;

/**
 * Class m200830_151227_alter_grievance_tbl
 */
class m200830_151227_alter_grievance_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE `grievance`   
  ADD COLUMN `is_review` TINYINT(1) DEFAULT 0  NULL AFTER `is_viewed`,
  ADD COLUMN `is_scan` TINYINT(1) DEFAULT 0  NULL AFTER `is_review`;
")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200830_151227_alter_grievance_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200830_151227_alter_grievance_tbl cannot be reverted.\n";

        return false;
    }
    */
}
