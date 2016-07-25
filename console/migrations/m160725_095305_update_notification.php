<?php

use yii\db\Migration;
use common\models\NotificationVerb;
class m160725_095305_update_notification extends Migration
{
    public function up()
    {
        
        $notification_verb_people_comment_thread = 
                NotificationVerb::find()->where(['notification_verb_name' => 'people_comment',
                                                 'notification_type_name' => 'thread'])->one();
        $notification_verb_people_comment_thread->text_template_two_people = "%1$% and 1 other commented on your thread %2$%";
        $notification_verb_people_comment_thread->update();
        

    }

    public function down()
    {
        echo "m160725_095305_update_notification cannot be reverted.\n";

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
