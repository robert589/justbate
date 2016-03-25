<?php

namespace frontend\controllers;


use common\models\Choice;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\data\SqlDataProvider;
use yii\data\Pagination;
use frontend\models\ChoiceForm;
use frontend\models\CreateThreadForm;
use common\models\User;
use common\models\Model;

class DashboardController extends Controller{

    const  MAXIMUM_OPTION  = 8;
    const MINIMUM_OPTION = 2;
    public function actionCreate(){
        //initialize create thread form
        $thread = new CreateThreadForm();
        $thread->user_id = \Yii::$app->user->getId();

        //initialize
        $choices = array();
        for($i = 0; $i < self::MAXIMUM_OPTION ; $i++){
            $choices[] = new ChoiceForm();
            $choices[$i]->index = $i;
        }
        //Load data if exists
        if ($thread->load(Yii::$app->request->post()) &&
            Model::loadMultiple($choices,Yii::$app->request->post())){

            $isValid = Model::validateMultiple($choices);
                        $isValid = $thread->validate() && $isValid;

            if($isValid){
                if($resultThread = $thread->create()){
                    //load multiple
                    foreach($choices as $choice){
                        if(!$choice->store()){
                            return null;
                        }
                    }
                    return $this->redirect(Yii::getAlias('@base-url') . '/site/home');
                }


            }



        }

        //Initialize default value, agree and disagree
        if(strcmp($choices[0]->choice_text, "") == 0 ){
            $choices[0]->choice_text = "Agree";
            $choices[0]->disabled = false;
        }
        if(strcmp($choices[1]->choice_text, "") == 0 ){
            $choices[1]->choice_text = "Disagree";
            $choices[1]->disabled = false;
        }


        return $this->render('create', ['thread' => $thread, 'choices' =>  $choices, 'maximum_option' => self::MAXIMUM_OPTION]);


    }

    public function actionUserList(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!empty($_GET['q'])) {
            $q = $_GET['q'];
            $userList = User::getUserList($q);
            $out['results'] = array_values($userList);
        }

        return $out;
    }

    public function actionTopicList(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!empty($_GET['q'])) {
            $q = $_GET['q'];
            $topicList = \common\models\ThreadTopic::getTopicList($q);
            $out['results'] = array_values($topicList);
        }

        return $out;
    }
}

