<?php

use yii\db\Migration;

class m160708_090153_update_constraint_on_update_cascade_thread_comment extends Migration
{
    public function up()
    {
        $this->execute("
            ALTER TABLE `thread_comment`
                DROP FOREIGN KEY `thread_comment_ibfk_2`;

            ALTER TABLE `thread_comment`
                ADD CONSTRAINT `thread_comment_ibfk_2`
                FOREIGN KEY (`choice_text`, `thread_id`)
                REFERENCES `choice`(`choice_text`, `thread_id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE;
        ");
    }


    public function down()
    {
        echo "m160708_090153_update_constraint_on_update_cascade cannot be reverted.\n";

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
