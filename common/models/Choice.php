<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
class Choice extends ActiveRecord
{

    public function getTable(){
        return 'choice';

    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public static function getChoice($thread_id){
        $sql = "SELECT choice_text from choice where thread_id = :thread_id";
        $result =  \Yii::$app->db->createCommand($sql)->
        bindParam(':thread_id', $thread_id)->
        queryAll();


        return $result;
    }

    public static function getChoiceAndItsVoters($thread_id){
        $sql = "Select choice_and_its_voters.choice_text as choice_text,
                    total_voters,
                    count(comment_id) as total_comments
                from(
                    select thread_choice.choice_text,
                           count(user_id) as total_voters
                    from (select choice_text from choice where thread_id = :thread_id) thread_choice
                    left join
                            (select user_id, choice_text
                             from thread_vote
                             where thread_id = :thread_id) current_thread_vote
                    on thread_choice.choice_text = current_thread_vote.choice_text
                    group by(thread_choice.choice_text)
                    ) choice_and_its_voters
                left join
                    ( select thread_comment.* from thread_comment,comment where thread_id = :thread_id and
                     comment.comment_id = thread_comment.comment_id and comment.comment_status = 10) comment_with_id
                on comment_with_id.choice_text = choice_and_its_voters.choice_text
                group by (choice_and_its_voters.choice_text)
                order by total_comments desc
        ";

        $result =  \Yii::$app->db->createCommand($sql)->
                    bindParam(':thread_id', $thread_id)->
                    queryAll();

        return $result;
    }

    public static function getMappedChoiceAndItsVoters($thread_id){
        $thread_choice = self::getChoiceAndItsVoters($thread_id);
        //Map it in proper way
        return $thread_choice;
    }

}