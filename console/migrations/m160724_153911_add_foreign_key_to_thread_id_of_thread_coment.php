<?php

use yii\db\Migration;

/**
 * Handles adding foreign_key to table `thread_id_of_thread_coment`.
 */
class m160724_153911_add_foreign_key_to_thread_id_of_thread_coment extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->execute("alter table thread_comment add constraint thread_comment_thread_id_fk foreign key(thread_id) references thread(thread_id)");
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
    }
}
