<?php

use yii\db\Migration;

/**
 * Class m190624_052534_alter_company_tbl
 */
class m190624_052534_alter_company_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE  `company`   
            ADD COLUMN `updated_on` INT NULL AFTER `created_on`;
        ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190624_052534_alter_company_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190624_052534_alter_company_tbl cannot be reverted.\n";

        return false;
    }
    */
}
