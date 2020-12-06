<?php

use yii\db\Migration;

/**
 * Class m200830_140201_create_scan_review_tbl
 */
class m200830_140201_create_scan_review_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("CREATE TABLE  `grievance_scan_review`(  
  `id` INT NOT NULL AUTO_INCREMENT,
  `grievance_id` INT NOT NULL,
  `type` ENUM('SCAN','REVIEW') NOT NULL,
  `date` DATE NOT NULL,
  `reason` TEXT NOT NULL,
  `comment` TEXT,
  `created_by` INT,
  `created_on` INT,
  PRIMARY KEY (`id`),
  INDEX `grievance_scan_review_grievance_id` (`grievance_id`),
  UNIQUE INDEX `grievance_scan_review_composite_unique` (`grievance_id`, `type`),
  INDEX `grievance_scan_review_created_by` (`created_by`),
  CONSTRAINT `grievance_scan_review_grievance_id` FOREIGN KEY (`grievance_id`) REFERENCES  `grievance`(`id`) ON UPDATE NO ACTION ON DELETE CASCADE,
  CONSTRAINT `grievance_scan_review_created_by` FOREIGN KEY (`created_by`) REFERENCES  `user`(`id`) ON UPDATE NO ACTION ON DELETE CASCADE
);
")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200830_140201_create_scan_review_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200830_140201_create_scan_review_tbl cannot be reverted.\n";

        return false;
    }
    */
}
