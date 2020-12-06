<?php

use yii\db\Migration;

/**
 * Class m190822_103845_alter_grievance_tbl
 */
class m190822_103845_alter_grievance_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE  `grievance`   
        DROP COLUMN `transaction_number`, 
        DROP COLUMN `transaction_refund_date`, 
        ADD COLUMN `approved_shares` INT NULL AFTER `refund_amount`,
        ADD COLUMN `approved_amount` DECIMAL(10,2) NULL AFTER `approved_shares`,
        ADD COLUMN `approved_share_date` DATE NULL AFTER `approved_amount`,
        ADD COLUMN `approved_amount_date` DATE NULL AFTER `approved_rejected_date`;
      ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190822_103845_alter_grievance_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190822_103845_alter_grievance_tbl cannot be reverted.\n";

        return false;
    }
    */
}
