<?php

use yii\db\Migration;

/**
 * Class m190802_075014_alter_company_info_tbl
 */
class m190802_075014_alter_company_info_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE  `company_info`   
        CHANGE `contact_person` `contact_person` VARCHAR(75) CHARSET latin1 COLLATE latin1_swedish_ci NOT NULL,
        CHANGE `email` `email` VARCHAR(100) CHARSET latin1 COLLATE latin1_swedish_ci NOT NULL;
      ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190802_075014_alter_company_info_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190802_075014_alter_company_info_tbl cannot be reverted.\n";

        return false;
    }
    */
}
