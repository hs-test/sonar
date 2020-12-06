<?php

use yii\db\Migration;

/**
 * Class m190823_060306_grievance_alter_import_depository_type
 */
class m190823_060306_grievance_alter_import_depository_type extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE `grievance` ADD `import_depository_type` ENUM('NSDL','CDSL','AMOUNT') NULL DEFAULT NULL AFTER `pay_status`;")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190823_060306_grievance_alter_import_depository_type cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190823_060306_grievance_alter_import_depository_type cannot be reverted.\n";

        return false;
    }
    */
}
