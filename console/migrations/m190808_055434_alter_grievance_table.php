<?php

use yii\db\Migration;

/**
 * Class m190808_055434_alter_grievance_table
 */
class m190808_055434_alter_grievance_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE  `grievance`   
             CHANGE `applicant_bank_account_no` `applicant_bank_account_no` VARCHAR(20) NULL;
        ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190808_055434_alter_grievance_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190808_055434_alter_grievance_table cannot be reverted.\n";

        return false;
    }
    */
}
