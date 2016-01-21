<?php

namespace frontend\controllers;


use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\data\SqlDataProvider;
use yii\data\Pagination;

use frontend\models\Dashboard;
use frontend\models\ThreadTopic;
use frontend\models\CreateThreadForm;
use common\models\User;

class DashboardController extends Controller{

    public function actionCreate(){
      //  var_dump($_POST);
        $thread = new CreateThreadForm();

        //Retrieve all topics
        $threadTopics = ThreadTopic::retrieveAll();
        $threadTopics = ArrayHelper::map($threadTopics,'topic_name', 'topic_name');

        //Retrieve all bsuiness people
        $businessPeople = User::retrieveAllBusinessPeople();
        $businessPeople = ArrayHelper::map($businessPeople, 'id', 'fullNameAndOccupation');


        //Is there any relevant parties being tag
        if(isset($_POST['relevant_parties'])){

        }

        //Is there any coordinate being tag
        if(isset($_POST['coordinate'])){

        }

        //Load data if exists
        if ($thread->load(Yii::$app->request->post())){



            if($thread->create()){
                return $this->render('create-confirm', ['thread' => $thread]);
            }
        }




        return $this->render('create', ['thread' => $thread, 'threadTopics' => $threadTopics, 'businessPeople' => $businessPeople]);


    }

}

