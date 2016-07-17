<?php

use yii\db\Migration;

class m160716_082138_thread_view_comment_view_thread_ignore extends Migration
{
    public function up()
    {
        $this->execute("CREATE TABLE thread_view(
                user_id int not null,
                thread_id int not null,
                created_at int not null,
                updated_at int not null,
                primary key(user_id, thread_id),
                foreign key(user_id) references user(id),
                foreign key(thread_id) references thread(thread_id)
            );");

        $uniq_time = time();
        $this->execute("INSERT INTO thread_view(thread_id, user_id, created_at, updated_at)
                        SELECT  thread_id, user_id, $uniq_time, $uniq_time 
                        from  thread_vote
                        UNION  
                        SELECT thread_id, user_id, $uniq_time, $uniq_time 
                        from thread_comment 
                        inner join comment on thread_comment.comment_id = comment.comment_id ");

        $this->execute("CREATE TABLE thread_ignore(
                user_id int not null,
                thread_id int not null,
                created_at int not null,
                updated_at int not null,
                primary key(user_id, thread_id),
                foreign key(user_id) references user(id),
                foreign key(thread_id) references thread(thread_id)
            )");

        $this->execute("CREATE TABLE comment_view (
                user_id int not null,
                comment_id int not null,
                created_at int not null,
                updated_at int not null,
                primary key(user_id, comment_id),
                foreign key(user_id) references user(id),
                foreign key(comment_id) references comment(comment_id)
            )");

        $this->execute("INSERT INTO comment_view(comment_id, user_id, created_at, updated_at)
                        SELECT DISTINCT comment_id, user_id, $uniq_time, $uniq_time from comment_vote
                        UNION
                        SELECT DISTINCT parent_id, user_id, $uniq_time, $uniq_time from child_comment inner join comment on child_comment.comment_id = comment.comment_id");

        return true;
    }

    public function down()
    {
        echo "m160716_082138_thread_view_comment_view_thread_ignore cannot be reverted.\n";

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
