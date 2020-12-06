<?php

use yii\db\Migration;

/**
 * Class m190713_112020_alter_grievance_message_log_table
 */
class m190713_112020_alter_grievance_message_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190713_112020_alter_grievance_message_log_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190713_112020_alter_grievance_message_log_table cannot be reverted.\n";

        return false;
    }
    */
}
