<?php

use yii\db\Migration;

/**
 * Class m190802_094110_alter_grievance_tbl
 */
class m190802_094110_alter_grievance_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //$this->db->createCommand("")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190802_094110_alter_grievance_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190802_094110_alter_grievance_tbl cannot be reverted.\n";

        return false;
    }
    */
}
