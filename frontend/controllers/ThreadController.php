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


        if(!empty($_GET['id'])){
            $id = $_GET['id'];
            //thread data
            $thread = Thread::retrieveThreadById($id);

            //comment model
            $commentModel = new CommentForm();
            if($commentModel->load(Yii::$app->request->post())) {
                
            }

            //retrieve yes data
            $yesCommentData = new SqlDataProvider([
                'sql' => Comment::retrieveSqlYesComment($id),  
                'totalCount' => Comment::countYesComment($id),
              
                'pagination' => [
                    'pageSize' =>5,
                ],

            ]);

            //retrieve no data
            $noCommentData = new SqlDataProvider([
                'sql' => Comment::retrieveSqlNoComment($id),  
                'totalCount' => Comment::countNoComment($id),
              
                'pagination' => [
                    'pageSize' =>5,
                ],

            ]);

            return $this->render('index', ['model' => $thread, 'yesCommentData' => $yesCommentData, 'noCommentData' => $noCommentData,  'commentModel' => $commentModel]);
        }
        

        return $this->render('index');
    }
}
