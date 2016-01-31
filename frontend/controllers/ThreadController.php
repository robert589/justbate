<?php
namespace frontend\controllers;

use frontend\models\SubmitThreadVoteForm;
use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use frontend\models\CommentForm;
use frontend\models\Comment;
use frontend\models\CommentLikeForm;
use frontend\models\ChildCommentForm;
use frontend\models\EditCommentForm;

use frontend\models\Thread;
use frontend\models\Rate;

use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\SqlDataProvider;
use frontend\models\ThreadVote;

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

        Yii::trace( Yii::$app->user->identity);

        
        if(!empty($_GET['id'])){

            $thread_id = $_GET['id'];

            $editCommentModel  =new EditCommentForm();

            if(!empty($_POST['vote']) && !empty($_POST['comment_id'])){
                $commentlikesModel = new CommentLikeForm();
                $commentlikesModel->comment_id = $_POST['comment_id'];
                $commentlikesModel->comment_likes = $_POST['vote'];

                if(!$commentlikesModel->store()){
                    return $this->render('../site/error');
                }

            }
            else if(!empty($_POST['child-vote']) && !empty($_POST['comment_id'])){
                $commentlikesModel = new CommentLikeForm();
                $commentlikesModel->comment_id = $_POST['comment_id'];
                $commentlikesModel->comment_likes = $_POST['child-vote'];
                if(!$commentlikesModel->store()){
                    return $this->render('../site/error');
                }
                else{
                    $model = Comment::retrieveCommentByUserId($commentlikesModel->comment_id, Yii::$app->user->identity->getId());
                    return $this->renderPartial('_list_child_comment', ['model' => $model]);

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

                if(Yii::$app->user->isGuest){
                     $model = Comment::retrieveCommentByUserId($comment_id, 0);
                   
                }
                else{
                     $model = Comment::retrieveCommentByUserId($comment_id, 
                                                        \Yii::$app->user->identity->id);
                   
                }
                              
                return $this->renderAjax('_list_comment', ['model' => $model, 'retrieveChildData' => $retrieveChildData, 'comment_id' => $comment_id, 'thread_id' => $thread_id]);

            }

            else if(!empty($_POST['userThreadRate'])){
                $userThreadRate = $_POST['userThreadRate'];

                $rateModel = new Rate();
                $rateModel->rating = $userThreadRate;
                $rateModel->thread_id = $thread_id;
                $rateModel->user_id = \Yii::$app->user->getId();

                if(!$rateModel->insertRating()){
                    return false;
                }
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

                
                $model = Comment::retrieveCommentByUserId($parent_id, \Yii::$app->user->identity->id);


                if($childCommentModel->store()){
                    if($commentRetrieved){
                           $retrieveChildData = new SqlDataProvider([
                            'sql' => Comment::retrieveChildComment($parent_id),  
                           'totalCount' => Comment::countChildComment($parent_id),
                            'pagination' => [
                                'pageSize' =>5,
                            ],

                        ]);
                        return $this->renderAjax('_list_comment', ['model' => $model, 'retrieveChildData' => $retrieveChildData, 'comment_id' => $parent_id, 'thread_id' => $thread_id]);
                    }
                    else{
                        return $this->renderAjax('_list_comment', ['model' => $model, 'comment_id' => $parent_id, 'thread_id' => $thread_id]);
                    }
                }
                else{
                    Yii::$app->end();
                }             

                

            }
            else if($editCommentModel->load(Yii::$app->request->post()) && $editCommentModel->validate()){
                if(!$editCommentModel->update()){

                }
            }


            
                  
            //thread data
            $thread = Thread::retrieveThreadById($thread_id, 
                \Yii::$app->user->getId());
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

    public function actionSubmitVote(){

        if(isset($_POST['voteThread']) && isset($_POST['thread_id'])){
            $voteThread = $_POST['voteThread'];
            $thread_id = $_POST['thread_id'];
            $thread_vote_form = new SubmitThreadVoteForm($thread_id, $voteThread);

            if($thread_vote_form->submitVote()){
                $model = ThreadVote::getTotalLikeDislikeBelongs($thread_id, Yii::$app->user->getId());
                return $this->renderPartial('_submit_vote_pjax', ['thread_id' => $thread_id, 'model' => $model]);

            }
            else{

            }

        }
    }
}
