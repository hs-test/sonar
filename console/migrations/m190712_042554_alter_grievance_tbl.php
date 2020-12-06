<?php

use yii\db\Migration;

/**
 * Class m190712_042554_alter_grievance_tbl
 */
class m190712_042554_alter_grievance_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE `grievance`   
         ADD  INDEX `grievance_dh_id` (`dh_id`),
         ADD CONSTRAINT `grievance_dh_id` FOREIGN KEY (`dh_id`) REFERENCES `user`(`id`) ON UPDATE NO ACTION;
        ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190712_042554_alter_grievance_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190712_042554_alter_grievance_tbl cannot be reverted.\n";

        return false;
    }
    */
}
