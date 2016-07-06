<?php

use yii\db\Migration;

class m160706_164639_move_read_notification_to_another_table extends Migration
{
    public function up()
    {
        $this->execute("
            ALTER TABLE notification_receiver add is_read tinyint not null default 0;
            ALTER TABLE notification drop column is_read;
        ");
    }

    public function down()
    {
        echo "m160706_164639_move_read_notification_to_another_table cannot be reverted.\n";

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
