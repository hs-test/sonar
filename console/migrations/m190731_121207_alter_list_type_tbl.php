<?php

use yii\db\Migration;

/**
 * Class m190731_121207_alter_list_type_tbl
 */
class m190731_121207_alter_list_type_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE  `list_type`   
                    ADD COLUMN `description` VARCHAR(250) NULL AFTER `display_order`;
        ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190731_121207_alter_list_type_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190731_121207_alter_list_type_tbl cannot be reverted.\n";

        return false;
    }
    */
}
