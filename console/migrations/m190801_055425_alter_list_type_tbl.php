<?php

use yii\db\Migration;

/**
 * Class m190801_055425_alter_list_type_tbl
 */
class m190801_055425_alter_list_type_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE `list_type`   
            CHANGE `display_order` `display_order` TINYINT(2) NULL;
            ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190801_055425_alter_list_type_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190801_055425_alter_list_type_tbl cannot be reverted.\n";

        return false;
    }
    */
}
