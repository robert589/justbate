<?php
namespace backend\controllers;

use backend\models\BanThreadForm;
use backend\models\EditChoiceForm;
use backend\models\EditThreadForm;

use common\models\Choice;
use common\models\LoginForm;
use common\models\Thread;
use common\models\Issue;

use frontend\models\CreateThreadForm;

use Yii;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * Thread controller
 */
class ThreadController extends Controller
{
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
                        'actions' => ['edit', 'banned', 'create', 'issue-list'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
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

    public function actionBanned()
    {
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $ban_thread_form = new BanThreadForm();
            $ban_thread_form->thread_id = $id;
            if(!$ban_thread_form->update()){
                return $this->redirect(Yii::$app->request->baseUrl . '/site/error');
            }
            return $this->redirect(Yii::$app->request->baseUrl . '/site/thread');

        }
        else{
            return $this->redirect(Yii::$app->request->baseUrl . '/site/error');
        }

    }

    public function actionCreate()
    {
        $create_thread_form = new CreateThreadForm();
        $create_thread_form->user_id = \Yii::$app->user->id;
        if($create_thread_form->load(Yii::$app->request->post()) && $create_thread_form->validate()){
            if($create_thread_form->create()){
                return $this->redirect(Yii::$app->request->baseUrl . '/thread/create');
            }
        }
        return $this->render('create', ['create_thread_form' => $create_thread_form]);
    }

    public function actionIssueList()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!empty($_GET['q'])) {
            $q = $_GET['q'];
            $topicList = Issue::getIssueList($q);
            $out['results'] = array_values($topicList);
        }

        return $out;
    }

    public function actionEdit()
    {
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $queried_thread = Thread::findOne(['thread_id' => $id]);

            $choices = ArrayHelper::map(Choice::findAll(['thread_id' => $id]), 'choice_text', 'choice_text');

            $edit_thread_form = new EditThreadForm();
            $edit_thread_form->thread_id = $id;

            $edit_choice_forms = array();

            foreach($choices as $choice){
                $edit_choice_form = new EditChoiceForm();
                $edit_choice_form->thread_id = $id;
                $edit_choice_form->old_choice_text = $choice;
                $edit_choice_forms[] = $edit_choice_form;
            }

            if($edit_thread_form->load(Yii::$app->request->post()) && $edit_thread_form->validate()){

                if(Model::loadMultiple($edit_choice_forms, Yii::$app->request->post()) && Model::validateMultiple($edit_choice_forms)){

                    if($edit_thread_form->update()){
                        foreach($edit_choice_forms as $form){
                            if(!$form->update()){
                            }
                        }

                        return $this->redirect(Yii::$app->request->baseUrl . '../thread/' . $id);

                    }
                }
            }
            else{
                if($edit_thread_form->hasErrors()){
                    Yii::$app->end(print_r($edit_thread_form->getErrors()));
                }
            }

            return $this->render('edit', [
                'thread' => $queried_thread,
                'edit_thread_form' => new EditThreadForm(),
                'edit_choice_forms' => $edit_choice_forms
            ]);
        }
        else{
            return $this->redirect(Yii::$app->request->baseUrl . '/site/error');
        }
    }


}
