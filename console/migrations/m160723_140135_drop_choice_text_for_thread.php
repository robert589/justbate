<?php

use yii\db\Migration;

/**
 * Handles the dropping for table `choice_text_for_thread`.
 */
class m160723_140135_drop_choice_text_for_thread extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->execute('alter table thread_comment drop foreign key thread_comment_ibfk_2;'
                . 'alter table thread_comment drop column choice_text;');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
    }
}
