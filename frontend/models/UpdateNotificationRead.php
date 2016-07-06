<?php
namespace frontend\models;

use common\models\NotificationReceiver;
use common\models\User;
use yii\base\Model;
use Yii;

class UpdateNotificationRead extends Model
{
    public $user_id;

    public $notification_id;


    public function rules()
    {
        return [
            [['user_id', 'notification_id'], 'integer'],
            [['user_id', 'notification_id'], 'required']
        ];
    }

    public function update() {
        $notification_receiver = NotificationReceiver::find()->where(['notification_id' => $this->notification_id,
                                                                'receiver_id' => $this->user_id])->one();
        $notification_receiver->is_read = 1;
        if(!$notification_receiver->update()){
            return false;
        }

        return true;
    }

}
