<?php

use yii\db\Migration;

/**
 * Class m190926_071153_create_activity_log_comment_tbl
 */
class m190926_071153_create_activity_log_comment_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("CREATE TABLE `grievance_activity_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grievance_activity_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `grievance_activity_comment_activity_id` (`grievance_activity_id`),
  KEY `grievance_activity_comment_created_by` (`created_by`),
  CONSTRAINT `grievance_activity_comment_activity_id` FOREIGN KEY (`grievance_activity_id`) REFERENCES `grievance_activity_log` (`id`) ON UPDATE NO ACTION,
  CONSTRAINT `grievance_activity_comment_created_by` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON UPDATE NO ACTION
) ENGINE=InnoDB  DEFAULT CHARSET=latin1")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190926_071153_create_activity_log_comment_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190926_071153_create_activity_log_comment_tbl cannot be reverted.\n";

        return false;
    }
    */
}
