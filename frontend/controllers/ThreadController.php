<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use app\models\User;
use frontend\models\CommentForm;
use frontend\models\Comment;
use frontend\models\CommentLikeForm;
use frontend\models\CommentLikes;

use frontend\models\Thread;
use frontend\models\DebugForm;

use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\SqlDataProvider;


/**
 * Profile controller
 */
class ThreadController extends Controller
{
    /**
     * Displays thread.
     *
     * @return mixed
     */
    

    public function actionIndex(){

        

        
        if(!empty($_GET['id'])){


            if(!empty($_POST['vote']) && !empty($_POST['comment_id'])){
                $commentlikesModel = new CommentLikeForm();
                $commentlikesModel->comment_id = $_POST['comment_id'];
                $commentlikesModel->comment_likes = $_POST['vote'];


                if(!$commentlikesModel->store()){
                    return $this->render('../site/error');
                }
               
            }
                else if(!empty($_GET['comment_id'])){
                    $comment_id = $_GET['comment_id'];

                    //retrieve yes data
                    $retrieveChildData = new SqlDataProvider([
                        'sql' => Comment::retrieveChildComment($comment_id),  
                        'totalCount' => Comment::countChildComment($comment_id),
                        'pagination' => [
                            'pageSize' =>5,
                            ],

                    ]);
                    //WARNING
                    //HAVE TO FIND OUT NOT TO KEEP REFRESHING THE WHOLE PAGE
                    $model = Comment::retrieveCommentById($_GET['id']);

                    return $this->render('_list_comment.php', ['retrieveChildData' => $retrieveChildData, 'model' => $model]);

                }
        
            $thread_id = $_GET['id'];
            //thread data
            $thread = Thread::retrieveThreadById($thread_id);
            //comment model
            $commentModel = new CommentForm();
            $commentModel->thread_id = $thread_id;

            if($commentModel->load(Yii::$app->request->post()) && $commentModel->validate() ) {
                if($commentModel->store()){
                    $commentModel = new CommentForm();
                    $commentModel->thread_id = $thread_id;
                }
            }

            //retrieve yes data
            $yesCommentData = new SqlDataProvider([
                'sql' => Comment::retrieveSqlComment($thread_id, 1),  
                'totalCount' => Comment::countComment($thread_id, 1),
                'pagination' => [
                    'pageSize' =>5,
                ],

            ]);

            //retrieve no data
            $noCommentData = new SqlDataProvider([
                'sql' => Comment::retrieveSqlComment($thread_id, 0),  
                'totalCount' => Comment::countComment($thread_id, 0),
              
                'pagination' => [
                    'pageSize' =>5,
                ],

            ]);

            return $this->render('index', ['model' => $thread, 'yesCommentData' => $yesCommentData, 
                        'noCommentData' => $noCommentData,  'commentModel' => $commentModel]);
            
            
        }
        

        return $this->render('index');
    }


    public function actionRetrieveChildData(){
        if(!empty($_GET['comment_id'])){
                $comment_id = $_GET['comment_id'];

                //retrieve yes data
                $retrieveChildData = new SqlDataProvider([
                    'sql' => Comment::retrieveChildComment($comment_id),  
                    'totalCount' => Comment::countChildComment($comment_id),
                    'pagination' => [
                        'pageSize' =>5,
                        ],

                ]);

                return $this->render('_list_comment.php', ['retrieveChildData' => $retrieveChildData]);

           }
    }


    public function actionSubmitVote(){
        var_dump($_POST);
    }
}
