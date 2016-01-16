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

        $thread = new CreateThreadForm();

        //Retrieve all topics
        $threadTopics = ThreadTopic::retrieveAll();
        $threadTopics = ArrayHelper::map($threadTopics,'topic_name', 'topic_name');

        //Retrieve all bsuiness people
        $businessPeople = User::retrieveAllBusinessPeople();
        $businessPeople = ArrayHelper::map($businessPeople, 'id', 'fullNameAndOccupation');


        //Load data if exists
        if ($thread->load(Yii::$app->request->post())){
            if($thread->create()){
                return $this->render('create-confirm', ['thread' => $thread]);
            }
        }

        if(isset($_POST['coordinate'])){
            $thread->coordinate = $_POST['coordinate'];
        }

        return $this->render('create', ['thread' => $thread, 'threadTopics' => $threadTopics, 'businessPeople' => $businessPeople]);


    }

}

