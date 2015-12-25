<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Thread;
use frontend\models\CreateThread;


class DashboardController extends Controller{

	 public function actionCreate(){

        $thread = new CreateThread();


        if (($thread->load(Yii::$app->request->post()))&&($thread->create())){
            return $this->render('create-confirm', ['thread' => $thread]);
        } else {
            return $this->render('create', ['thread' => $thread]);
        }

    }

    public function actionDashPage(){
    	
    }
}

