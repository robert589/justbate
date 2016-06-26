<?php
namespace frontend\models;

use common\models\Issue;
use common\models\ThreadAnonymous;
use common\models\UserFollowedIssue;
use yii\base\Model;
use Yii;
use yii\web\UploadedFile;
use yii\validators\ImageValidator;
use common\models\ThreadVote;
use yii\web\User;

class ThreadAnonymousForm extends Model
{
    public $thread_id;

    public $user_id;



    public function rules()
    {
        return [
            [['user_id', 'thread_id'], 'integer'],
            [['user_id', 'thread_id'], 'required']
        ];
    }

    public function requestAnon(){
        if(!$this->checkExist()){
            $thread_anon = new ThreadAnonymous();
            $thread_anon->thread_id = $this->thread_id;
            $thread_anon->user_id = $this->user_id;
            return $thread_anon->save();
        }

        return true;
    }

    public function cancelAnon(){
        if($this->checkExist()){
            $thread_anon = ThreadAnonymous::find()->where(['user_id' => $this->user_id, 'thread_id' => $this->thread_id])->one();
            return $thread_anon->delete();
        }

        return true;
    }

    private  function checkExist(){
        return ThreadAnonymous::find()->where(['thread_id' => $this->thread_id, 'user_id' => $this->user_id])->exists();
    }

}
