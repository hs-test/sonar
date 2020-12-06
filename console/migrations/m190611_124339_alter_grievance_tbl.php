<?php

use yii\db\Migration;

/**
 * Class m190611_124339_alter_grievance_tbl
 */
class m190611_124339_alter_grievance_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE `grievance`   
  CHANGE `security_depository_type` `security_depository_type` ENUM('NSDL','CDSL') CHARSET latin1 COLLATE latin1_swedish_ci NULL;")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190611_124339_alter_grievance_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190611_124339_alter_grievance_tbl cannot be reverted.\n";

        return false;
    }
    */
}
