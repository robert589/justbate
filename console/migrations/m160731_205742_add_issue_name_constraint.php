<?php

use yii\db\Migration;

class m160731_205742_add_issue_name_constraint extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE `user_followed_issue`
              ADD CONSTRAINT `user_followed_issue_ibfk_2` FOREIGN KEY (`issue_name`) REFERENCES `issue` (`issue_name`); ");
                

    }

    public function down()
    {
        echo "m160731_205742_add_issue_name_constraint cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
