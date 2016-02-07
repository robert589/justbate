<?php
namespace frontend\models;

use yii\base\Model;
use Yii;
use yii\web\UploadedFile;
use yii\validators\ImageValidator;
use frontend\models\ThreadVote;

class SubmitThreadVoteForm extends Model
{
    public $user_id;

    public $thread_id;

    public $choice_text;


    public function rules()
    {
        return [
            [['thread_id', 'choice_text'], 'required'],
            [['user_id', 'thread_id'], 'integer'],
            ['choice_text', 'string']
        ];
    }

    public function submitVote()
    {
        if($this->checkExist()){
            return $this->updateVote();
        }
        else{
            return $this->insertVote();
        }
    }


    private function checkExist(){
        return ThreadVote::find()->where(['user_id' => $this->user_id])
            ->andWhere(['thread_id' => $this->thread_id])
            ->exists();
    }

    private function updateVote(){
        $thread_vote = ThreadVote::find()->where(['user_id' => $this->user_id])
            ->andWhere(['thread_id' => $this->thread_id])
            ->one();
        /*
        $thread_vote = self::findOne(['user_id' => $this->user_id,
                                    'thread_id' => $this->thread_id]);
           */
        if($thread_vote->agree == $this->agree){
            return true;
        }
        else{

            $thread_vote->agree = $this->agree;
            if($thread_vote->update()){
                return true;
            }
            else{
                return null;
            }

        }
    }

    private function insertVote(){
        $thread_vote = new ThreadVote();
        $thread_vote->user_id = $this->user_id;
        $thread_vote->thread_id = $this->thread_id;
        $thread_vote->agree = $this->agree;
        if($thread_vote->save()){
            return true;
        }
        else{
            return false;
        }
    }



}
