<?php

use yii\db\Migration;

/**
 * Class m200829_181256_alter_grivence_stat_tbl
 */
class m200829_181256_alter_grivence_stat_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("ALTER TABLE  `grievance_stat`   
  CHANGE `type` `type` ENUM('grievance','nsdl','amount','cdsl','vr','dr','approved','paid','underprocess','vrrejected','discripancyrejected') CHARSET latin1 COLLATE latin1_swedish_ci NULL;
")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200829_181256_alter_grivence_stat_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200829_181256_alter_grivence_stat_tbl cannot be reverted.\n";

        return false;
    }
    */
}
