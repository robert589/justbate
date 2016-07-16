<?php

use yii\db\Migration;

class m160708_095601_update_constraint_on_update_cascade_thread_vote extends Migration
{
    public function up()
    {
        $this->execute("
            ALTER TABLE `thread_vote`
                DROP FOREIGN KEY `thread_vote_ibfk_2`;

            ALTER TABLE `thread_vote`
                ADD CONSTRAINT `thread_vote_ibfk_2`
                FOREIGN KEY (`choice_text`, `thread_id`)
                REFERENCES `choice`(`choice_text`, `thread_id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE;
        ");
    }

    public function down()
    {
        echo "m160708_095601_update_constraint_on_update_cascade_thread_vote cannot be reverted.\n";

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
