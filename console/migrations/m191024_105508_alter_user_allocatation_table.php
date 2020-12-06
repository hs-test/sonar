<?php

use yii\db\Migration;

/**
 * Class m191024_105508_alter_user_allocatation_table
 */
class m191024_105508_alter_user_allocatation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand('ALTER TABLE `user_target_log`   
  ADD  INDEX `user_target_log_user_id` (`user_id`),
  ADD CONSTRAINT `user_target_log_user_id` FOREIGN KEY (`user_id`) REFERENCES `user`(`id`) ON UPDATE NO ACTION ON DELETE CASCADE;
')->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191024_105508_alter_user_allocatation_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191024_105508_alter_user_allocatation_table cannot be reverted.\n";

        return false;
    }
    */
}
