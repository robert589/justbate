<?php

namespace frontend\controllers;


use Yii;
use yii\web\Controller;
use yii\data\SqlDataProvider;
use yii\data\Pagination;
use yii\method\ActiveQuery;

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

    public function actionDash(){
    	$dash = new Thread();

        $thread = $dash->retrieveByUser();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $thread->count(),
            ]);

        $rows = $thread->orderBy('date_created')
                                      ->offset($pagination->offset)
                                      ->limit($pagination->limit)
                                      ->all();

        return $this->render('dash', ['rows' => $rows, 'pagination' => $pagination]);
    }
}

