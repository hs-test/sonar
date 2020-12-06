<?php

use yii\db\Migration;

/**
 * Class m190724_063120_alter_user_tbl
 */
class m190724_063120_alter_user_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE `user`   
        CHANGE `allowed_grievance` `allowed_grievance` INT(11) DEFAULT 50  NULL,
        CHANGE `allocated_grievance` `allocated_grievance` INT(3) DEFAULT 0  NOT NULL,
        CHANGE `is_last_allocated` `is_last_allocated` TINYINT(1) DEFAULT 0  NOT NULL;
      ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190724_063120_alter_user_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190724_063120_alter_user_tbl cannot be reverted.\n";

        return false;
    }
    */
}
