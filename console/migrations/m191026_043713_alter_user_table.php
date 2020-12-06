<?php

use yii\db\Migration;

/**
 * Class m191026_043713_alter_user_table
 */
class m191026_043713_alter_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE `user`   
                         ADD COLUMN `is_limit_achieved` TINYINT NULL AFTER `is_last_allocated`;
        ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191026_043713_alter_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191026_043713_alter_user_table cannot be reverted.\n";

        return false;
    }
    */
}
