<?php

use yii\db\Migration;

/**
 * Class m190822_112236_alter_grievance_tbl
 */
class m190822_112236_alter_grievance_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE `grievance`   
  CHANGE `approved_shares` `approved_shares` INT(11) NULL  AFTER `rack_no`,
  CHANGE `approved_amount` `approved_amount` DECIMAL(10,2) NULL  AFTER `approved_shares`,
  CHANGE `approved_share_date` `refund_share_date` DATE NULL,
  CHANGE `approved_amount_date` `refund_amount_date` DATE NULL  AFTER `refund_share_date`;
    ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190822_112236_alter_grievance_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190822_112236_alter_grievance_tbl cannot be reverted.\n";

        return false;
    }
    */
}
