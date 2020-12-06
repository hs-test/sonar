<?php

use yii\db\Migration;

/**
 * Class m191024_105235_alter_user_allocatation_table
 */
class m191024_105235_alter_user_allocatation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE  `user_target_log`   
  CHANGE `user_id` `user_id` INT(11) NOT NULL,
  CHANGE `month` `month` TINYINT(2) NOT NULL,
  CHANGE `year` `year` TINYINT(4) NOT NULL,
  CHANGE `date` `date` DATE NOT NULL,
  CHANGE `allocated` `allocated` INT(11) NOT NULL, 
  DROP INDEX `user_target_log_user_id`,
  DROP FOREIGN KEY `user_target_log_user_id`;
")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191024_105235_alter_user_allocatation_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191024_105235_alter_user_allocatation_table cannot be reverted.\n";

        return false;
    }
    */
}
