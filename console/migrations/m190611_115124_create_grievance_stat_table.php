<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%grievance_stat}}`.
 */
class m190611_115124_create_grievance_stat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("CREATE TABLE  `grievance_stat`(  
        `media_id` INT,
        `logs` TEXT,
        `total` INT,
        `success` INT,
        `failed` INT,
        `created_on` INT,
        INDEX `grievance_stat_media_id` (`media_id`),
        CONSTRAINT `grievance_stat_media_id` FOREIGN KEY (`media_id`) REFERENCES  `media`(`id`) ON UPDATE NO ACTION ON DELETE SET NULL
      );
      ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%grievance_stat}}');
    }
}
