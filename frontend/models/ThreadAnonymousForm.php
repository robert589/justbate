<?php
namespace frontend\models;

use common\models\ThreadAnonymous;
use frontend\dao\ThreadDao;
use yii\base\Model;
use Yii;

class ThreadAnonymousForm extends Model
{
    public $thread_id;

    public $user_id;

    private $thread_dao;

    public function init() {
        $this->thread_dao = new ThreadDao();
    }


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
            $thread_anon->anonymous_id = $this->checkMaxNumber() + 1;
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

    private function checkMaxNumber() {
        return ThreadAnonymous::find()->where(['thread_id' => $this->thread_id])->orderBy("anonymous_id")->one()->anonymous_id;
    }

    private  function checkExist(){
        return ThreadAnonymous::find()->where(['thread_id' => $this->thread_id, 'user_id' => $this->user_id])->exists();
    }

}
