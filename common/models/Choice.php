<?php

namespace common\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
class Choice extends ActiveRecord
{
    public function getTable(){
        return 'choice';

    }

    public static function getChoiceAndItsVoters($thread_id){
        $sql = "select thread_choice.choice_text,
                      concat(thread_choice.choice_text, ' (', count(user_id), ' voters) ') as choice_text_and_total_voters
                from (select choice_text from choice where thread_id = :thread_id) thread_choice
      		    left join
                    (select user_id, choice_text
                       from thread_vote
                       where thread_id = :thread_id) current_thread_vote

      		    on thread_choice.choice_text = current_thread_vote.choice_text
                group by(thread_choice.choice_text)
                    ";
        $result =  \Yii::$app->db->createCommand($sql)->
                    bindParam(':thread_id', $thread_id)->
                    queryAll();

        return $result;
    }

    public static function getMappedChoiceAndItsVoters($thread_id){
        $thread_choice = self::getChoiceAndItsVoters($thread_id);
        //Map it in proper way
        return ArrayHelper::map($thread_choice, 'choice_text', 'choice_text_and_total_voters');
    }

}