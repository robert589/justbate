<?php
namespace backend\controllers;

use common\models\Choice;
use backend\models\EditChoiceForm;
use backend\models\EditThreadForm;
use Yii;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use common\models\Thread;
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
                        'actions' => ['edit'],
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

    public function actionBanned(){
        if(isset($_GET['id'])){
            $id = $_GET['id'];

        }
    }

    public function actionEdit(){
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

            var_dump($_POST);
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
