<?php

use yii\db\Migration;

class m160702_184223_anonymous_id extends Migration
{
    public function up()
    {
        $this->execute("alter table thread_anonymous add anonymous_id int not null;
                        CREATE UNIQUE INDEX thread_id_anon_id on thread_anonymous(thread_id, anonymous_id);
        ");

    }

    public function down()
    {
        $this->execute("
alter table thread_anonymous drop column anonymous_id;");

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
