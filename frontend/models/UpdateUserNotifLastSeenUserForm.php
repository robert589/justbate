<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

class UpdateUserNotifLastSeenUserForm extends Model
{
    public $user_id;




    public function rules()
    {
        return [
            ['user_id', 'integer'],
            ['user_id', 'required']
        ];
    }

    public function update() {
        $user = User::findOne(['id' => $this->user_id]);
        $user->notif_last_seen = time();
        if(!$user->update()){
            return false;
        }

        return true;
    }

}
