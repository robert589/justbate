<?php
namespace frontend\models;

use common\models\Notification;
use common\models\NotificationActor;
use common\models\NotificationReceiver;
use yii\base\Model;
use common\models\Thread;
use common\models\User;
use common\models\Comment;
use common\models\FollowerRelation;

class NotificationForm extends Model
{
    const PEOPLE_COMMENT_ON_YOUR_THREAD = 1;
    const PEOPLE_VOTE_ON_YOUR_THREAD = 2;
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

    /**
     * Someone comments on the thread
     * @param $thread_id
     */
    public function submitCommentNotification($thread_id){
        if($this->validate()){
            $notification_id = $this->getNotificationId($thread_id, self::PEOPLE_COMMENT_ON_YOUR_THREAD);
            if(is_null($notification_id)){
                $notification = new Notification();
                $notification->notification_verb_id = self::PEOPLE_COMMENT_ON_YOUR_THREAD;
                $thread_title = Thread::findOne($thread_id)->title;
                $notification->url_key_value = $thread_id . '%,%' . $thread_title ;
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

    private function getNotificationId($thread_id, $notification_verb_id){
        $notification = Notification::find()->where(['url_key_value' => $thread_id, 'notification_verb_id' => $notification_verb_id])->one();

        if($notification !== null){
            return $notification->notification_id;
        }

        return null;
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