<?php
namespace backend\controllers;

use backend\models\BanIssueForm;
use backend\models\CreateIssueForm;
use backend\models\EditIssueForm;
use yii\data\ArrayDataProvider;
use backend\models\EditChoiceForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\Issue;
/**
 * Thread controller
 */
class IssueController extends Controller
{
    private $isAuth = true;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create','list', 'request', 'edit', 'banned'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if($action->id === "list"){
            if (!Yii::$app->user->can('view_all_issue')){
                $this->isAuth = false;
            }
        }
        else if ($action->id === "banned"){
            if (!Yii::$app->user->can('ban_issue')){
                $this->isAuth = false;
            }
        }
        else if ($action->id === "edit"){
            if (!Yii::$app->user->can('edit_issue')){
                $this->isAuth = false;
            }
        }
        else if ($action->id === "create"){
            if (!Yii::$app->user->can('create_issue')){
                $this->isAuth = false;
            }
        }
        else if ($action->id === "request"){
            if (!Yii::$app->user->can('request_issue')){
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

    public function actionBanned(){
        // check if user is authenticated
        if($this->isAuth === false){
            return $this->render('/site/prohibit');
        }

        if(isset($_GET['id'])){
            $id = $_GET['id'];

            $ban_issue_form = new BanIssueForm();
            $ban_issue_form->issue_id = $id;

            if ($ban_issue_form->validate() && $ban_issue_form->ban()) {
                return $this->redirect(Yii::$app->request->baseUrl . '/issue/list');
            }
            //return $this->redirect(Yii::$app->request->baseUrl. '/site/error');
        }

    }

    public function actionEdit(){
        // check if user is authenticated
        if($this->isAuth === false){
            return $this->render('/site/prohibit');
        }

        if(isset($_GET['id'])){
            $id = $_GET['id'];

            $issue = Issue::find()->where(['issue_id' => $id])->one();

            $edit_issue_form = new EditIssueForm();
            $edit_issue_form->issue_id = $id;
            if($edit_issue_form->load(Yii::$app->request->post()) && $edit_issue_form->validate()){
                if($edit_issue_form->update()){
                    return $this->redirect(Yii::$app->request->baseUrl . '/issue/list');
                }
            }
            return $this->render('edit', ['issue' => $issue, 'edit_issue_form' => $edit_issue_form]);
        }
    }

    public function actionList(){
        // check if user is authenticated
        if($this->isAuth === false){
            return $this->render('/site/prohibit');
        }

        $issue_list = Issue::find()->all();

        $issue_provider = new ArrayDataProvider([
            'allModels' => $issue_list,
            'pagination' => [
                'pageSize' => 30
            ]
        ]);

        return $this->render('list', ['issue_provider' => $issue_provider]);


    }

    public function actionCreate(){
        // check if user is authenticated
        if($this->isAuth === false){
            return $this->render('/site/prohibit');
        }

        $create_issue_form = new CreateIssueForm();

        if($create_issue_form->load(Yii::$app->request->post()) && $create_issue_form->validate()){
            if($create_issue_form->create()){
                return $this->render('create', ['create_issue_form' => new CreateIssueForm()]);
            }
        }

        return $this->render('create', ['create_issue_form' => new CreateIssueForm()]);


    }

    public function actionRequest(){
        // check if user is authenticated
        if($this->isAuth === false){
            return $this->render('/site/prohibit');
        }

        return $this->render('request');
    }
}
