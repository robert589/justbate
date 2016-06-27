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

            $vo = $service->getCommentInfo(Yii::$app->user->getId(), $_GET['id'], $_GET['comment_id']);

            if($vo instanceof ThreadCommentVo::class){

            }
            else if($vo instanceof  ChildCommentVo::class){

            }
            return $this->renderAjax( 'index' , ['list_notification_vo' => $vo] );
        }
    }



}

