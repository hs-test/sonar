<?php

use yii\db\Migration;

/**
 * Class m190805_013649_alter_message_template_tbl
 */
class m190805_013649_alter_message_template_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
//        $this->db->createCommand("ALTER TABLE `message_template`   
//                ADD COLUMN `subject` VARCHAR(150) NULL AFTER `type`;
//        ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190805_013649_alter_message_template_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190805_013649_alter_message_template_tbl cannot be reverted.\n";

        return false;
    }
    */
}
