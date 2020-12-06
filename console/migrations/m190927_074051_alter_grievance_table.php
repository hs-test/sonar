<?php

use yii\db\Migration;

/**
 * Class m190927_074051_alter_grievance_table
 */
class m190927_074051_alter_grievance_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE `grievance`   
        CHANGE `import_depository_type` `import_depository_type` ENUM('NSDL','CDSL') CHARSET latin1 COLLATE latin1_swedish_ci NULL,
        ADD COLUMN `is_amount_import` TINYINT(1) NULL AFTER `import_depository_type`;
    ")->execute();
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190927_074051_alter_grievance_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190927_074051_alter_grievance_table cannot be reverted.\n";

        return false;
    }
    */
}
