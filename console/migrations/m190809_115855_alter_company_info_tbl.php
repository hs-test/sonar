<?php

use yii\db\Migration;

/**
 * Class m190809_115855_alter_company_info_tbl
 */
class m190809_115855_alter_company_info_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("RENAME TABLE  `company_details` TO  `company_detail`;
        ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190809_115855_alter_company_info_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190809_115855_alter_company_info_tbl cannot be reverted.\n";

        return false;
    }
    */
}
