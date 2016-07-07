<?php
namespace frontend\models;

use common\components\Constant;
use common\entity\CommentEntity;
use common\libraries\CommentUtility;
use common\models\Notification;
use common\models\NotificationActor;
use common\models\NotificationExtraValue;
use common\models\NotificationReceiver;
use common\models\NotificationType;
use common\models\NotificationVerb;
use yii\base\Model;
use common\models\Thread;
use common\models\User;
use common\models\Comment;
use common\models\FollowerRelation;
use yii\helpers\HtmlPurifier;

class NotificationForm extends Model
{
    /**
     * @var User that causes other users to be notified
     */
    public $actor_id;

    public function rules()
    {
        return [
            [['actor_id'], 'required'],
            [['actor_id'], 'integer'],

        ];
    }

    public function submitChildCommentNotification( $thread_id, $comment_id){
        if($this->validate()){
            $notification = $this->getNotification($thread_id . '%,%' .$comment_id, NotificationType::COMMENT_TYPE, NotificationVerb::PEOPLE_COMMENT_ON_YOUR_COMMENT);
            if(is_null($notification)){
                $notification = new Notification();
                $notification->notification_verb_name = NotificationVerb::PEOPLE_COMMENT_ON_YOUR_COMMENT;
                $notification->notification_type_name = NotificationType::COMMENT_TYPE;
                $comment_text = CommentUtility::cutText(Comment::findOne($comment_id)->comment);
                $notification->url_key_value = $thread_id . '%,%' . $comment_id;
                if(!$notification->save()){
                    //error
                }

                $notification_id = $notification->notification_id;
                $notification_receiver = new NotificationReceiver();
                $notification_receiver->notification_id = $notification->notification_id;
                $notification_receiver->receiver_id = Comment::find()->where(['comment_id' => $comment_id])->one()->user_id;
                if(!$notification_receiver->save()){
                    //error
                }

                $notification_extra_value = new NotificationExtraValue();
                $notification_extra_value->notification_type_name = $notification->notification_type_name;
                $notification_extra_value->url_key_value = $notification->url_key_value;
                $notification_extra_value->extra_value =  Constant::removeAllHtmlTag($comment_text);
                if(!$notification_extra_value->save()){
                    //error
                }
            } else {
                $notification_id = $notification->notification_id;
                NotificationReceiver::updateAll(['is_read' => 1], 'notification_id = '. $notification_id);

            }



            $notification_actor = $this->getNotificationActor($notification_id, $this->actor_id);
            if(is_null($notification_actor)){
                $notification_actor = new NotificationActor();
                $notification_actor->notification_id = $notification_id;
                $notification_actor->actor_id = $this->actor_id;
                if(!$notification_actor->save()){
                    //error
                }
            }
            else{
                $notification_actor->updated_at = 'unix_timestamp()';
                if(!$notification_actor->update()){
                    //error
                }
            }

            return true;
        }
    }

    /**
     * Someone comments on the thread
     * @param $thread_id
     */
    public function submitCommentNotification($thread_id){
        if($this->validate()){
            $notification = $this->getNotification($thread_id, NotificationType::THREAD_TYPE, NotificationVerb::PEOPLE_COMMENT_ON_YOUR_THREAD);
            if(is_null($notification)){
                $notification = new Notification();
                $notification->notification_verb_name = NotificationVerb::PEOPLE_COMMENT_ON_YOUR_THREAD;
                $notification->notification_type_name = NotificationType::THREAD_TYPE;
                $thread_title = Thread::findOne($thread_id)->title;
                $notification->url_key_value = $thread_id;
                if(!$notification->save()){
                    //error
                }
                $notification_id = $notification->notification_id;
                $notification_receiver = new NotificationReceiver();
                $notification_receiver->notification_id = $notification->notification_id;
                $notification_receiver->receiver_id = Thread::find()->where(['thread_id' => $thread_id])->one()->user_id;
                if(!$notification_receiver->save()){
                    //error
                }

                $notification_extra_value = new NotificationExtraValue();
                $notification_extra_value->notification_type_name = $notification->notification_type_name;
                $notification_extra_value->url_key_value = $notification->url_key_value;
                $notification_extra_value->extra_value = $thread_title;
                if(!$notification_extra_value->save()){
                    //error
                }
            }
            else  {
                $notification_id = $notification->notification_id;
                NotificationReceiver::updateAll(['is_read' => 1], 'notification_id = '. $notification_id);
            }

            $notification_actor = $this->getNotificationActor($notification_id, $this->actor_id);
            if(is_null($notification_actor)){
                $notification_actor = new NotificationActor();
                $notification_actor->notification_id = $notification_id;
                $notification_actor->actor_id = $this->actor_id;
                if(!$notification_actor->save()){
                    //error
                }
            }
            else{
                $notification_actor->updated_at = 'unix_timestamp()';
                if(!$notification_actor->update()){
                    //error
                }
            }
            return true;
        }
        return false;
    }

    private function getNotificationActor($notification_id, $actor_id){
        return NotificationActor::find()->where(['notification_id' => $notification_id, 'actor_id' => $actor_id])->one();
    }

    private function getNotification($url_key_value, $notification_type_name, $notification_verb_name){

        return Notification::find()->where(['url_key_value' => $url_key_value,
                                                    'notification_type_name' => $notification_type_name,
                                                    'notification_verb_name' => $notification_verb_name])->one();
    }

    /**
     * Someone comments on the comment
     */
    public function insertChildCommentNotification($thread_comment_id){
        $this->triggered_id = Comment::find()->where(['comment_id' => $thread_comment_id])->one()['user_id'];

        if($this->validate()){
            $trigger_user = User::findIdentity(['user_id' => $this->trigger_id]);
            $trigger_user_full_name = $trigger_user['first_name'] . ' ' . $trigger_user['last_name'];
            $trigger_user_link = \Yii::$app->request->baseUrl . '/user/' . $trigger_user['username'];

            $notification = new Notification();
            $notification->user_id = $this->triggered_id;
            $notification->description = "<a data-pjax=0 href='". $trigger_user_link .  "'>$trigger_user_full_name</a> commented on your comment";

            if($notification->save()){
                return true;
            }
            else{
                //error
            }

        }

    }

}

?>