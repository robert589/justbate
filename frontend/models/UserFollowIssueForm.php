<?php
namespace frontend\models;

use common\models\Issue;
use common\models\UserFollowedIssue;
use yii\base\Model;
use Yii;
use yii\web\UploadedFile;
use yii\validators\ImageValidator;
use common\models\ThreadVote;
use yii\web\User;

class UserFollowIssueForm extends Model
{
    public $user_id;

    public $issue_name;



    public function rules()
    {
        return [
            ['user_id', 'integer'],
            ['issue_name', 'string'],
            [['user_id', 'issue_name'], 'required']
        ];
    }

    public function followIssue()
    {
        if(!$this->checkExist()){
            $user_follow_issue = new UserFollowedIssue();
            $user_follow_issue->user_id = $this->user_id;
            $user_follow_issue->issue_name = $this->issue_name;

            if(!$user_follow_issue->save()){
                return false;
            }

        }

        return true;
    }

    public function unfollowIssue(){
        if($this->checkExist()){
            $user_follow_issue = UserFollowedIssue::find()->where(['issue_name' => $this->issue_name, 'user_id' => $this->user_id])->one();

            if(!$user_follow_issue->delete()){
                return false;
            }
        }

        return true;
    }


    private function checkExist(){
        return UserFollowedIssue::find()->where(['user_id' => $this->user_id, 'issue_name' => $this->issue_name])->exists();
    }


    private function findIssueId(){
        return Issue::findOne(['issue_name' => $this->issue_name ])->issue_id;


    }
}
