<?php

use yii\db\Migration;

/**
 * Class m190727_044944_alter_grievance_tbl
 */
class m190727_044944_alter_grievance_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE  `grievance`   
             ADD COLUMN `is_viewed` TINYINT(1) NULL AFTER `status`;
        ")->execute();
     }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190727_044944_alter_grievance_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190727_044944_alter_grievance_tbl cannot be reverted.\n";

        return false;
    }
    */
}
