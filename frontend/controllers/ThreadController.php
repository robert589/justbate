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
use frontend\models\ChildCommentForm;

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

            $thread_id = $_GET['id'];


            if(!empty($_POST['vote']) && !empty($_POST['comment_id'])){
                $commentlikesModel = new CommentLikeForm();
                $commentlikesModel->comment_id = $_POST['comment_id'];
                $commentlikesModel->comment_likes = $_POST['vote'];


                if(!$commentlikesModel->store()){
                    return $this->render('../site/error');
                }
               
            }
    
            else if(Yii::$app->request->isPjax && !empty($_GET['comment_id'])){
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
                 //   Yii::$app->end(Yii::$app->request->isPjax);
                  
                return $this->renderAjax('_list_comment', ['retrieveChildData' => $retrieveChildData, 'comment_id' => $comment_id, 'thread_id' => $thread_id]);

            }

            else if(Yii::$app->request->isPjax && !empty($_POST['childComment'])){

                $parent_id = $_POST['parent_id'];
                $childComment = $_POST['childComment'];
                $commentRetrieved = 0;
                if(!empty($_POST['commentRetrieved'])){
                    $commentRetrieved = $_POST['commentRetrieved'];
                }

                $childCommentModel = new ChildCommentForm();

                $childCommentModel->childComment = $childComment;
                $childCommentModel->thread_id = $thread_id;
                $childCommentModel->parent_id = $parent_id;

                

               
                if($childCommentModel->store()){
                    if($commentRetrieved){
                           $retrieveChildData = new SqlDataProvider([
                            'sql' => Comment::retrieveChildComment($parent_id),  
                           'totalCount' => Comment::countChildComment($parent_id),
                            'pagination' => [
                                'pageSize' =>5,
                            ],

                        ]);
                        return $this->renderAjax('_list_comment', ['retrieveChildData' => $retrieveChildData, 'comment_id' => $parent_id, 'thread_id' => $thread_id]);
                    }
                    else{
                        return $this->renderAjax('_list_comment', ['comment_id' => $parent_id, 'thread_id' => $thread_id]);
                    }
                }
                else{
                    Yii::$app->end();
                }

               

                

            }

            
                  
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


}
