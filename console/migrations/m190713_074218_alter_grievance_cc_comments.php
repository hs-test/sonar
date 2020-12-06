<?php

use yii\db\Migration;

/**
 * Class m190713_074218_alter_grievance_cc_comments
 */
class m190713_074218_alter_grievance_cc_comments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("RENAME TABLE  `grievance_cc_comments` TO  `grievance_cc_comment`;")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190713_074218_alter_grievance_cc_comments cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190713_074218_alter_grievance_cc_comments cannot be reverted.\n";

        return false;
    }
    */
}
