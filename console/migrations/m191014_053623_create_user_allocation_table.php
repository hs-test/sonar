<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_allocation}}`.
 */
class m191014_053623_create_user_allocation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("CREATE TABLE `user_target_log`(  
        `user_id` INT,
        `date` DATE,
        `allocated` INT,
        `created_on` INT,
        INDEX `user_target_log_user_id` (`user_id`),
        CONSTRAINT `user_target_log_user_id` FOREIGN KEY (`user_id`) REFERENCES `user`(`id`) ON UPDATE NO ACTION ON DELETE CASCADE
      );
      ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_allocation}}');
    }
}
