<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\SqlDataProvider;
use yii\data\Pagination;
use frontend\models\Dashboard;
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
    	$dash = new Dashboard();

        $displayed_thread = new SqlDataProvider([
                
                'title' => $dash->retrieveByUser()->thread_title,  
                'date_created' => $dash->retrieveByUser()->date,
                'content' => $dash->retrieveByUser()->text,
              
                'pagination' => [
                    'pageSize' =>5,
                ],

            ]);

        return $this->render('dash-page', ['dash' => $dash, 'displayed_thread' => $displayed_thread]);
    }
}

