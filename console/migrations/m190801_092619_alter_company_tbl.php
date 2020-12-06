<?php

use yii\db\Migration;

/**
 * Class m190801_092619_alter_company_tbl
 */
class m190801_092619_alter_company_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE `company`   
            DROP COLUMN `email`, 
            DROP COLUMN `contact_person`, 
            DROP COLUMN `address`;
        ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190801_092619_alter_company_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190801_092619_alter_company_tbl cannot be reverted.\n";

        return false;
    }
    */
}
