<?php

use yii\db\Migration;

/**
 * Class m190808_074538_rename_comapny_info
 */
class m190808_074538_rename_comapny_info extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("RENAME TABLE `company_info` TO `company_details`;")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190808_074538_rename_comapny_info cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190808_074538_rename_comapny_info cannot be reverted.\n";

        return false;
    }
    */
}
