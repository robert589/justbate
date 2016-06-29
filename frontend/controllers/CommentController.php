<?php

namespace frontend\controllers;

use common\entity\ChildCommentVo;
use frontend\service\ServiceFactory;
use frontend\vo\ThreadCommentVo;
use Yii;
use yii\web\Controller;

class CommentController extends Controller{

    /**
     * @var ServiceFactory
     */
    private $serviceFactory;

    public function init() {
        $this->serviceFactory = new ServiceFactory();
    }


    public function actionIndex(){
        if(isset($_GET['id']) && isset($_GET['comment_id'])){
            $service = $this->serviceFactory->getService(ServiceFactory::COMMENT_SERVICE);
            $vo = $service->getCommentInfo(Yii::$app->user->getId(), $_GET['id'], $_GET['comment_id'],
                isset($_GET['child']));
            if($vo === null){
                return $this->redirect(Yii::$app->request->baseUrl . '/site/not-found');
            }
            else if($vo instanceof ThreadCommentVo){
                return $this->render('index', ['thread_comment' => $vo] );
            }
        }
    }



}

