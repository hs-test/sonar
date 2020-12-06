<?php

use yii\db\Migration;

/**
 * Class m190904_081915_alter_company_tbl
 */
class m190904_081915_alter_company_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE  `company`   
             ADD COLUMN `depository` ENUM('NSDL','CDSL','AMOUNT') NULL AFTER `cin_no`;
    ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190904_081915_alter_company_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190904_081915_alter_company_tbl cannot be reverted.\n";

        return false;
    }
    */
}
