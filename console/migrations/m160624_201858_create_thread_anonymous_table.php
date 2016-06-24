<?php

use yii\db\Migration;

/**
 * Handles the creation for table `thread_anonymous_table`.
 */
class m160624_201858_create_thread_anonymous_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->execute(

            'CREATE TABLE thread_anonymous (
              thread_id int not null,
              user_id int not null,
              primary key(thread_id, user_id),
              foreign key(thread_id) references thread(thread_id),
              FOREIGN key(user_id) REFERENCES user(id)
            )'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('thread_anonymous_table');
    }
}
