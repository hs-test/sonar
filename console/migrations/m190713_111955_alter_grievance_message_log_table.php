<?php

use yii\db\Migration;

/**
 * Class m190713_111955_alter_grievance_message_log_table
 */
class m190713_111955_alter_grievance_message_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE `grievance_message_log`   
            ADD  INDEX `message_log_grievance_id` (`grievance_id`),
            ADD CONSTRAINT `message_log_grievance_id` FOREIGN KEY (`grievance_id`) REFERENCES `grievance`(`id`) ON UPDATE NO ACTION;
          ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190713_111955_alter_grievance_message_log_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190713_111955_alter_grievance_message_log_table cannot be reverted.\n";

        return false;
    }
    */
}
