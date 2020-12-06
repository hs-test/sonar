<?php

use yii\db\Migration;

/**
 * Class m190808_054307_alter_grievance_table
 */
class m190808_054307_alter_grievance_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE `grievance`   
        CHANGE `applicant_accountno` `applicant_bank_account_no` BIGINT(16) NULL,
        ADD COLUMN `applicant_bank_name` VARCHAR(255) NULL AFTER `applicant_bank_account_no`,
        ADD COLUMN `applicant_bank_branch` VARCHAR(200) NULL AFTER `applicant_bank_name`,
        ADD COLUMN `applicant_micr_code` VARCHAR(100) NULL AFTER `applicant_bank_branch`,
        CHANGE `applicant_dmat_accountno` `applicant_dmat_account_no` VARCHAR(100) NULL;
      ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190808_054307_alter_grievance_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190808_054307_alter_grievance_table cannot be reverted.\n";

        return false;
    }
    */
}
