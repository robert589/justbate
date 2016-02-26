<?php
namespace frontend\models;

use common\models\Notification;
use yii\base\Model;
use common\models\Thread;
use common\models\User;
use common\models\FollowerRelation;

class NotificationForm extends Model
{
    /**
     * @var User that causes other users to be notified
     */
    public $trigger_id;

    /**
     * User that is notified
     * @return array
     */
    public $triggered_id;

    public function rules()
    {
        return [
            [['trigger_id', 'triggered_id'], 'required'],
            [['trigger_id', 'triggered_id'], 'integer'],

        ];
    }

    /**
     * Someone comments on the thread
     * @param $thread_id
     */
    public function insertCommentNotification($thread_id){
        $this->triggered_id = Thread::find()->where(['thread_id' => $thread_id])->one()['user_id'];
        if($this->validate()){
            $trigger_user = User::findIdentity(['user_id' => $this->trigger_id]);
            $trigger_user_full_name = $trigger_user['first_name'] . ' ' . $trigger_user['last_name'];
            $trigger_user_link = \Yii::$app->request->baseUrl . '/profile/index/username=' . $trigger_user['username'];
            $notification = new Notification();
            $notification->user_id = $this->triggered_id;
            $notification->description = "<a href='". $trigger_user_link .  "'>$trigger_user_full_name</a> commented on your thread";

            if($notification->save()){
                return true;
            }
            else{
                //error
            }
        }


    }

    /**
     * Someone comments on the comment
     */
    public function insertChildCommentNotification($thread_comment_id){
        $this->triggered_id = Comment::find()->where(['comment_id' => $thread_comment_id])->one()['user_id'];

        if($this->validate()){
            $trigger_user = User::findIdentity(['user_id' => $this->trigger_id]);
            $trigger_user_full_name = $trigger_user['first_name'] . ' ' . $trigger_user['last_name'];
            $trigger_user_link = \Yii::$app->request->baseUrl . '/profile/index/username=' . $trigger_user['username'];

            $notification = new Notification();
            $notification->user_id = $this->triggered_id;
            $notification->description = "<a href='". $trigger_user_link .  "'>$trigger_user_full_name</a> commented on your comment";

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