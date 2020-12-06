<?php

use yii\db\Migration;

/**
 * Class m190623_113959_alter_grievance_tbl
 */
class m190623_113959_alter_grievance_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE `grievance`   
        ADD COLUMN `posting_date` DATE NULL AFTER `mobile`,
        ADD COLUMN `transaction_description` VARCHAR(255) NULL AFTER `posting_date`,
        ADD COLUMN `nomial_amount_share` DECIMAL(10,2) NULL AFTER `transaction_description`,
        ADD COLUMN `total` INT NULL AFTER `nomial_amount_share`;
      ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190623_113959_alter_grievance_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190623_113959_alter_grievance_tbl cannot be reverted.\n";

        return false;
    }
    */
}
