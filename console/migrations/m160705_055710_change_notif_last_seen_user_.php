<?php

use yii\db\Migration;

class m160705_055710_change_notif_last_seen_user_ extends Migration
{
    public function up()
    {
        $this->execute("
        CREATE TABLE old_user like user;
        insert old_user select * from user;
        alter table user modify column notif_last_seen int;
        UPDATE user, old_user
        set user.notif_last_seen = UNIX_TIMESTAMP(old_user.notif_last_seen)
         where user.id = old_user.id;");
    }

    public function down()
    {
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
