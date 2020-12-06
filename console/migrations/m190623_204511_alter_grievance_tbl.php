<?php

use yii\db\Migration;

/**
 * Class m190623_204511_alter_grievance_tbl
 */
class m190623_204511_alter_grievance_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE `grievance`   
            CHANGE `total` `total` DECIMAL(10,2) NULL;")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190623_204511_alter_grievance_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190623_204511_alter_grievance_tbl cannot be reverted.\n";

        return false;
    }
    */
}
