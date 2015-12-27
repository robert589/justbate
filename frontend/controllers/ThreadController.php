<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use app\models\User;
use frontend\models\CommentForm;
use frontend\models\Comment;
use frontend\models\Thread;

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

        var_dump($_POST);

        if(!empty($_GET['id'])){
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

            return $this->render('index', ['model' => $thread, 'yesCommentData' => $yesCommentData, 'noCommentData' => $noCommentData,  'commentModel' => $commentModel]);
        }
        

        return $this->render('index');
    }

    public function actionSubmitVote(){
        var_dump($_POST);
    }
}
