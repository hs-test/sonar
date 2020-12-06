<?php

use yii\db\Migration;

/**
 * Class m190716_044011_alter_grievance_cc_comment_tbl
 */
class m190716_044011_alter_grievance_cc_comment_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE  `grievance_cc_comment`   
         CHANGE `comments` `comment` TEXT CHARSET latin1 COLLATE latin1_swedish_ci NOT NULL;
        ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190716_044011_alter_grievance_cc_comment_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190716_044011_alter_grievance_cc_comment_tbl cannot be reverted.\n";

        return false;
    }
    */
}
