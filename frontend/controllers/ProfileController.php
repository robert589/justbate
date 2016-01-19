<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use frontend\models\Comment;
use frontend\models\CommentLikes;
use frontend\models\Thread;


/**
 * Profile controller
 */
class ProfileController extends Controller
{


    public function actionIndex()
    {
    	if(isset($_GET['username'])){
            $user = new User();
            $username = $_GET['username'];
            $user->username = $_GET['username'];
            if($user->checkUsernameExist()){
                $user_info =  $user->getUser();
                $user_recent_activity = $this->getRecentActivity($username);
                return $this->render('index', ['user' => $user_info]);
            }
            else{
                Yii::$app->end();
                return $this->render('user-not-found', ['username' => $username]);
            }
        }
        else{
            $username = "";
            return $this->render('user-not-found', ['username' => $username]);
        }

    }

    public function actionProfile()
    {
        $id = \Yii::app()->user->getId();
        return $this->redirect(array('/user/','id'=>Yii::app()->user->getId()));
    }



    private function getRecentActivity($username){
        $user_comment_recent_activity = Comment::getRecentCommentActivity($username);
        $user_comment_likes_recent_activity = CommentLikes::getRecentCommentLikes($username);
        $user_thread_activity = Thread::getRecentActivityCreateThread($username);

        return $this->mergeAllActivities($user_comment_recent_activity, $user_comment_likes_recent_activity, $user_thread_activity);
    }


    //TO BE CONTINUED
    private function mergeAllActivities($comment_activities, $comment_likes_acitivities, $thread_acitivties){
        $recent_activity = array();
        $ca_counter = 0;
        $cl_counter = 0;
        $ta_counter = 0;


        foreach($comment_activities as $comment_activity){
            foreach($comment_likes_acitivities as $comment_likes_acitivty){
                if($comment_activity['date_created'] > $comment_likes_acitivty['date_created']){
                   // $recent_activity[] = "You commented on "
                }
                else{
                    //$recent_activity[] = ""
                    break;
                }
            }
        }

    }

    //UNDER PROGRESS
    private function minDateCreated($comment_activity, $comment_like, $thread_activity ){

    }
 }
    
