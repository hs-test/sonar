<?php

use yii\db\Migration;

/**
 * Class m190801_102548_create_company_info_tbl
 */
class m190801_102548_create_company_info_tbl extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->db->createCommand("CREATE TABLE  `company_info`(  
            `id` INT NOT NULL AUTO_INCREMENT,
            `company_id` INT,
            `name` VARCHAR(75),
            `email` VARCHAR(100),
            `address` VARCHAR(150),
            `created_at` INT,
            PRIMARY KEY (`id`),
            INDEX `company_info_company_id` (`company_id`),
            CONSTRAINT `company_info_company_id` FOREIGN KEY (`company_id`) REFERENCES `company`(`id`) ON UPDATE NO ACTION ON DELETE CASCADE
          );
            ")->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190801_102548_create_company_info_tbl cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190801_102548_create_company_info_tbl cannot be reverted.\n";

        return false;
    }
    */
}
