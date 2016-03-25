<?php
namespace backend\controllers;

use common\models\ChildComment;
use common\models\ThreadComment;
use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use common\models\Thread;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    /*
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['thread', 'login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    */

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionChildComment(){
        $all_child_comment = ChildComment::getAllChildComments();

        $child_comment_provider = new ArrayDataProvider([
            'allModels' => $all_child_comment,
            'pagination' => [
                'pageSize' => 30
            ]
        ]);

        return $this->render('child-comment', ['child_comment_provider' => $child_comment_provider]);

    }

    public function actionThread(){
        $all_threads = Thread::find()->all();

        $thread_provider = new ArrayDataProvider([
            'allModels' => $all_threads,
            'pagination' => [
                'pageSize' => 30
            ]
        ]);

        return $this->render('thread', ['thread_provider' => $thread_provider]);
    }

    public function actionThreadComment(){
        $all_thread_comment = ThreadComment::getAllThreadComments();

        $thread_comment_provider = new ArrayDataProvider([
            'allModels' => $all_thread_comment,
            'pagination' => [
                'pageSize' => 30
            ]
        ]);

        return $this->render('thread-comment', ['thread_comment_provider' => $thread_comment_provider]);

    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    
}
