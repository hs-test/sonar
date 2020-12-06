<?php

use yii\db\Migration;

/**
 * Class m190801_104635_alter_company_tbl
 */
class m190801_104635_alter_company_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE `company_info` CHANGE `created_at` `created_on` INT(11) NULL;")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190801_104635_alter_company_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190801_104635_alter_company_tbl cannot be reverted.\n";

        return false;
    }
    */
}
