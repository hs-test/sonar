<?php

use yii\db\Migration;

/**
 * Class m190808_075934_alter_company_details
 */
class m190808_075934_alter_company_details extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE `company_details` ADD UNIQUE(`email`);")->execute();
        $this->db->createCommand("ALTER TABLE `company_details` ADD `contact_no` VARCHAR(50)DEFAULT NULL AFTER `contact_person`;")->execute();
        $this->db->createCommand("ALTER TABLE `company_details` ADD UNIQUE(`contact_no`);")->execute();
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190808_075934_alter_company_details cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190808_075934_alter_company_details cannot be reverted.\n";

        return false;
    }
    */
}
