<?php

use yii\db\Migration;

/**
 * Class m190808_062300_alter_grievance_table
 */
class m190808_062300_alter_grievance_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE `grievance`   
            CHANGE `applicant_address` `applicant_address` VARCHAR(255) CHARSET latin1 COLLATE latin1_swedish_ci NULL;
        ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190808_062300_alter_grievance_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190808_062300_alter_grievance_table cannot be reverted.\n";

        return false;
    }
    */
}
