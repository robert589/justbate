<?php

use yii\db\Migration;

class m160629_164829_update_text_for_notification extends Migration
{
    public function up()
    {
        $this->execute("
          INSERT INTO notification_type(notification_type_name, url_template, created_at, updated_at)
          values('comment', 'thread/%1$%/comment/%2$%/%3$%', now(), now());

          INSERT INTO notification_verb(notification_type_name, notification_verb_name, text_template, text_template_two_people,
          text_template_more_than_two_people, created_at, updated_at)
          values('comment', 'people_comment', '%1$% replied on your comment \"%2$%\"', '%1$% and %2$% replied on your comment \"%3$%\"',
          '%1$% and %2$% other people replied on your comment \"%3$%\"', now(), now());

          UPDATE  notification_verb
          set text_template = '%1$% commented on your thread \"%2$%\"', text_template_two_people = '%1$% and %2$% commented on your thread \"%3$%\"'
          , text_template_more_than_two_people = '%1$% and %2$% other people commented on your thread \"%3$%\"'
          where notification_verb_name = 'people_comment' and notification_type_name = 'thread';
         ");

    }



    public function down()
    {

        $this->execute("
          UPDATE notification_verb
          set text_template = '%1$% commented on your thread' , text_template_two_people = '%1$% and %2$% commented on your thread'
          , text_template_more_than_two_people = '%1$% and %2$% other people commented on your thread'
          where notification_verb_name = 'people_comment' and notification_type_name ='thread';

          DELETE from notification_verb
          where notification_type_name = 'comment' and notification_verb_name = 'people_comment';

          DELETE from notification_type
          where notification_type_name = 'comment';
         ");
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
