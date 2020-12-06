<?php

use yii\db\Migration;

/**
 * Class m190612_073141_alter_grievance_stat_tble
 */
class m190612_073141_alter_grievance_stat_tble extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE  `grievance_stat`   
            ADD COLUMN `id` INT NOT NULL AUTO_INCREMENT FIRST,
            ADD COLUMN `company_created_count` TINYINT NULL AFTER `logs`,
            ADD COLUMN `company_created_name` TEXT NULL AFTER `company_created_count`, 
            ADD PRIMARY KEY (`id`);
        ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190612_073141_alter_grievance_stat_tble cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190612_073141_alter_grievance_stat_tble cannot be reverted.\n";

        return false;
    }
    */
}
