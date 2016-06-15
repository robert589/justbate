<?php
namespace backend\controllers;

use common\models\ChildComment;
use common\models\ThreadComment;
use common\models\LoginForm;
use common\models\Thread;
use common\models\User;
use common\components\DateTimeFormatter;

use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\rbac\DbManager;

use backend\entity\HomeEntity;
use backend\creator\CreatorFactory;
use backend\creator\HomeCreator;

/**
 * Site controller
 */
class SiteController extends Controller
{
    private $isAuth = true;

    public function beforeAction($action)
    {
        if($action->id === "index"){
            if(key(\Yii::$app->authManager->getRolesByUser(\Yii::$app->user->getId())) !== 'admin'){
                $this->isAuth = false;
            }
        }
        else if($action->id === "thread"){
            if (!Yii::$app->user->can('view_all_thread')){
                $this->isAuth = false;
            }
        }
        else if($action->id === "thread-comment"){
            if (!Yii::$app->user->can('view_all_thread_comment')){
                $this->isAuth = false;
            }
        }
        else if($action->id === "child-comment"){
            if (!Yii::$app->user->can('view_all_child_comment')){
                $this->isAuth = false;
            }
        }
        else if($action->id === "user"){
            if (!Yii::$app->user->can('view_all_user')){
                $this->isAuth = false;
            }
        }
        else{
            $this->isAuth = true;
        }
        return true;
    }

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
        // check if user is signed in
        if (!\Yii::$app->user->isGuest) {

            // check if user is authenticated
            if($this->isAuth === false){
                return $this->render('prohibit');
            }

            // creating home factory
            $user_id = Yii::$app->user->getId();
            $entity = new HomeEntity($user_id);
            $creator = (new CreatorFactory())->getCreator(CreatorFactory::HOME_CREATOR, $entity);

            // creating home entity
            $home_entity = $creator->get([HomeCreator::NEED_WELCOME]);

            return $this->render('index', [
                'home' => $home_entity,
            ]);
        }
        else
        {
            $model = new LoginForm();
            return $this->render('login', [
                'model' => $model,
            ]);
        }

    }

    public function actionChildComment()
    {
        // check if user is authenticated
        if($this->isAuth === false){
            return $this->render('prohibit');
        }

        $all_child_comment = ChildComment::getAllChildComments();

        $child_comment_provider = new ArrayDataProvider([
            'allModels' => $all_child_comment,
            'pagination' => [
                'pageSize' => 30
            ]
        ]);

        return $this->render('child-comment', ['child_comment_provider' => $child_comment_provider]);

    }

    public function actionThread()
    {
        // check if user is authenticated
        if($this->isAuth === false){
            return $this->render('prohibit');
        }

        $all_threads = Thread::find()->all();
        $thread_provider = new ArrayDataProvider([
            'allModels' => $all_threads,
            'pagination' => [
                'pageSize' => 30
            ]
        ]);

        return $this->render('thread', ['thread_provider' => $thread_provider]);
    }

    public function actionThreadComment()
    {
        // check if user is authenticated
        if($this->isAuth === false){
            return $this->render('prohibit');
        }

        $all_thread_comment = ThreadComment::getAllThreadComments();

        $thread_comment_provider = new ArrayDataProvider([
            'allModels' => $all_thread_comment,
            'pagination' => [
                'pageSize' => 30
            ]
        ]);
        $actionid = $this->action->id;
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

    public function actionUser()
    {
        // check if user is authenticated
        if($this->isAuth === false){
            return $this->render('prohibit');
        }

        $registered_user = User::find()->all();

        //modify date format
        foreach ($registered_user as $row) {
            foreach ($row as $key => $value) {
                if($key === 'created_at' || $key === 'updated_at'){
                    $row[$key] = DateTimeFormatter::getTimeByTimestampAndTimezoneOffset($value);
                }
            }
        }

        $user_provider = new ArrayDataProvider([
            'allModels' => $registered_user,
            'pagination' => [
                'pageSize' => 30
            ]
        ]);

        return $this->render('user', ['user_provider' => $user_provider]);
    }

}
