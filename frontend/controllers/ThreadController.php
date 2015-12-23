<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use app\models\User;
use frontend\models\Thread;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

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
    

    public function actionIndex()
    {   
        if(!empty($_GET['id'])){
            $id = $_GET['id'];

            $thread = Thread::retrieveThreadById($id);
            

            return $this->render('index', ['model' => $thread]);
        }
        

        return $this->render('index');
    }
}
