<?php

namespace frontend\controllers;

use common\creator\CommentCreator;
use frontend\models\CommentViewForm;
use common\entity\ThreadCommentEntity;
use common\models\Thread;
use common\models\ThreadComment;
use frontend\models\ChildCommentForm;
use frontend\models\CommentVoteForm;
use frontend\models\DeleteCommentForm;
use frontend\models\NotificationForm;
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
        if(isset($_GET['comment_id']) && isset($_GET['id'])){
            $service = $this->serviceFactory->getService(ServiceFactory::COMMENT_SERVICE);
            $vo = $service->getThreadCommentInfo(Yii::$app->user->getId(), $_GET['id'], $_GET['comment_id']);
            $this->updateCommentView($_GET['comment_id']);
        
            if($vo === null){
                return $this->redirect(Yii::$app->request->baseUrl . '/site/not-found');
            }
            else if($vo instanceof ThreadCommentVo){
                if($vo->getCommentStatus() == 0){
                    return $this->render('comment-deleted');
                }
                return $this->render('index', ['thread_comment' => $vo] );
            }
        }
    }


    /**
     * POST DATA: user_id, parent_id, ChildCommentForm
     * return: render
     */
    public function actionSubmitChildComment() {
        if(!Yii::$app->user->isGuest && isset($_POST['text']) && isset($_POST['parent_id'])) {
            $child_comment_form = new ChildCommentForm();
            $child_comment_form->user_id = Yii::$app->user->getId();
            $child_comment_form->parent_id = $_POST['parent_id'];
            $child_comment_form->child_comment = $_POST['text'];
            if(!$child_comment_form->validate()){
                return false;
            }
            $parent_id = $child_comment_form->parent_id;
            $thread_id = ThreadComment::findOne(['comment_id' =>$parent_id])->thread_id;
            if(!$this->updateChildCommentNotification($child_comment_form->user_id, $thread_id, $parent_id)){
                return false;
            }
            if(!($new_comment_id = $child_comment_form->store())){
                return false;
            }
            $service = $this->serviceFactory->getService(ServiceFactory::COMMENT_SERVICE);
            $vo  = $service->getChildCommentInfo(Yii::$app->user->getId(), $new_comment_id);
       
            $this->updateCommentView($_POST['parent_id']);
            return \frontend\widgets\ChildComment::widget(['child_comment' => $vo, 
                'id' => 'child-comment-new-list-'. $new_comment_id]);
        }
        else{
           return false;
        }   
    }

    private function updateChildCommentNotification($actor_id, $thread_id, $comment_id){
        $notification_form = new NotificationForm();
        $notification_form->actor_id = $actor_id;
        if($notification_form->submitChildCommentNotification($thread_id, $comment_id) == true){
            return true;
        }
    }

    public function actionGetChildComment(){
        if(!(isset($_GET['comment_id']) && isset($_GET['thread_id']))) {
            Yii::$app->end('comment_id not poster');
        }
        $comment_id = $_GET['comment_id'];
        $thread_id = $_GET['thread_id'];
        $service = $this->serviceFactory->getService(ServiceFactory::COMMENT_SERVICE);
        $vo  = $service->getChildCommentList(Yii::$app->user->getId(), $comment_id, $thread_id);
        $child_comment_form = new ChildCommentForm();
        $this->updateCommentView($_GET['comment_id']);
        
        return $this->render('child-comment-list', ['thread_comment' => $vo,
            'retrieved' => true,
            'is_thread_comment' => false,
            'child_comment_form' => $child_comment_form]);

    }

    
    

    /**
     * @ajax
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionGetNewChildComment() {
        if( !(isset($_POST['last_time']) && 
                isset($_POST['comment_id']) 
                && isset($_POST['limit']))) {
            return 0;
        }
        $last_time = $_POST['last_time'];
        $limit = $_POST['limit'];
        $current_user_id = !Yii::$app->user->isGuest ? Yii::$app->user->getId() : 0;
        $comment_id = $_POST['comment_id'];
        $service = $this->serviceFactory->getService(ServiceFactory::COMMENT_SERVICE);
        $child_comment_vos = $service->getNewChildCommentList($comment_id, $current_user_id, $last_time, $limit);
        
        $view = '';
        foreach($child_comment_vos as $vo) {
            $view .= \frontend\widgets\ChildComment::widget(['id' => 'child-comment-' . $vo->getCommentId(),
                'child_comment' => $vo]);
        }
        if(count($child_comment_vos) !== 0) {
            $new_last_time = array_pop($child_comment_vos)->getCreatedAtUnixTimestamp();
            
        } else {
            $new_last_time = 0;
        }
        $data = array();
        $data['view'] = $view;
        $data['last_time']  = $new_last_time;
        return json_encode($data);
    }


    /**
     * @return \yii\web\Response
     */
    public function actionDeleteComment(){
        if(isset($_POST['comment_id']) && !Yii::$app->user->isGuest){
            $delete_comment_form = new DeleteCommentForm();
            $delete_comment_form->comment_id = $_POST['comment_id'];
            $delete_comment_form->user_id = Yii::$app->user->getId();
            if($delete_comment_form->delete()){
                return true;
                
            }
        }
        
        return false;
    }

    /**
     *
     */
    public function actionCommentVote(){
        //Yii::$app->end(var_dump($_POST));
        if(!(isset($_POST['comment_id']) && isset($_POST['vote']))) {
            Yii::$app->end('Fail to like: Contact Admin');
        }
        $comment_vote_form = new CommentVoteForm();
        $comment_vote_form->user_id = Yii::$app->user->getId();
        $comment_vote_form->vote = $_POST['vote'];
        $comment_vote_form->comment_id =  $_POST['comment_id'];
        
        $this->updateCommentView($_POST['comment_id']);
        if (!$comment_vote_form->validate()) {
            return false;
        }
        if ($comment_vote_form->store() !== true) {
            return false;
        }
        return true;
    }

    private function updateCommentView($comment_id) {
        $comment_view_form = new CommentViewForm();
        $comment_view_form->user_id = Yii::$app->user->getId();
        $comment_view_form->comment_id = $comment_id;
        $comment_view_form->store();
        
    }
    
}

