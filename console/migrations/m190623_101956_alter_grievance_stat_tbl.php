<?php

use yii\db\Migration;

/**
 * Class m190623_101956_alter_grievance_stat_tbl
 */
class m190623_101956_alter_grievance_stat_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE  `grievance_stat`   
        DROP COLUMN `company_created_count`, 
        CHANGE `company_created_name` `company_logs` TEXT CHARSET latin1 COLLATE latin1_swedish_ci NULL;
      ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190623_101956_alter_grievance_stat_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190623_101956_alter_grievance_stat_tbl cannot be reverted.\n";

        return false;
    }
    */
}
