<?php

use yii\db\Migration;

/**
 * Class m190807_114702_alter_grievance_activity_tbl
 */
class m190807_114702_alter_grievance_activity_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE  `list_type`   
                CHANGE `description` `description` VARCHAR(250) CHARSET latin1 COLLATE latin1_swedish_ci NOT NULL, 
                ADD  UNIQUE INDEX `list_type_description` (`description`);
        ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190807_114702_alter_grievance_activity_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190807_114702_alter_grievance_activity_tbl cannot be reverted.\n";

        return false;
    }
    */
}
