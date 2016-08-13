<?php
namespace frontend\controllers;

use common\components\LinkConstructor;
use common\entity\CommentEntity;
use frontend\widgets\ThreadCommentInputBox;
use frontend\models\ThreadViewForm;
use frontend\models\DeleteCommentForm;
use frontend\models\DeleteThreadForm;
use frontend\models\EditCommentForm;
use frontend\models\NotificationForm;;
use frontend\models\SubmitThreadVoteForm;
use frontend\models\ThreadAnonymousForm;
use frontend\service\ServiceFactory;
use frontend\vo\ThreadVoBuilder;
use Yii;
use yii\web\Controller;
use frontend\models\CommentForm;
use frontend\models\ChildCommentForm;
use frontend\models\EditThreadForm;

use common\models\Thread;
/**
 * Profile controller
 */
class ThreadController extends Controller
{
    /**
     * @var ServiceFactory
     */
    private $serviceFactory;

    public function init() {
            $this->serviceFactory = new ServiceFactory();
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionIndex(){
            if(empty($_GET['id'])) {
                    return $this->redirect(Yii::$app->request->baseUrl . '/site/error');
            }

            $service = $this->serviceFactory->getService(ServiceFactory::THREAD_SERVICE);
            $thread = $service->getThreadInfo( $_GET['id'],Yii::$app->user->getId(), new ThreadVoBuilder());
            $commentModel = new CommentForm();
            $submit_vote_form = new SubmitThreadVoteForm();
            $this->setMetaTag($thread->getThreadId(),
                                              $thread->getTitle(),
                                              $thread->getDescription());
            if($thread->getThreadStatus() === Thread::STATUS_BANNED) {
                    return $this->render('banned');
            }
            $this->updateThreadView($_GET['id']);

            return $this->render('index', ['thread' => $thread,
                                               'comment_model' => $commentModel,
                                                                       'submit_vote_form' => $submit_vote_form,
                                           ]);
    }



    /**
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionRetrieveCommentInput(){
        if(!(isset($_POST['thread_id']))) {
            Yii::$app->end('Something went wrong, we will fix it as soon as possible');
        }
        $thread_id =  $_POST['thread_id'];
        $service = $this->serviceFactory->getService(ServiceFactory::THREAD_SERVICE);
        $thread = $service->getThreadInfoForRetrieveCommentInput( $_POST['thread_id'],Yii::$app->user->getId(), new ThreadVoBuilder());
        $current_user_comment = $thread->getCurrentUserComment();

        $comment_model = new CommentForm();
        if(!is_null($current_user_comment)) {
            $comment_model->comment = $current_user_comment;
        }
        return ThreadCommentInputBox::widget(['id' => 'thread-comment-input-box-' . $thread_id, 
            'thread' => $thread
            ]);

    }


    /**
     * WEAKNESS: If server validation error occur, no solution other than saying error
     * POST DATA: Comment Model;
     */
    public function actionSubmitComment(){
        if(Yii::$app->user->isGuest || !isset($_POST['thread_id']) || !isset($_POST['comment'])) {
            Yii::$app->end('You should login before submitting the comment');
        }
        $comment_model = new CommentForm();
        $thread_id = $_POST['thread_id'];
        $comment = $_POST['comment'];
        $user_id = Yii::$app->user->getId();
        $comment_model->thread_id =  $thread_id;
        $comment_model->user_id = $user_id;
        $comment_model->comment = $comment;
        if(!$comment_model->validate() ) {
            return false;
        }
        
        if(!($comment_id = $comment_model->store())) {
            return false;
        }
        
        if(!$this->updateCommentNotification($comment_model->user_id, $thread_id)){
        }   
        $service = $this->serviceFactory->getService(ServiceFactory::COMMENT_SERVICE);
        $thread_comment = $service->getThreadCommentInfo(Yii::$app->user->getId(), $thread_id, $comment_id);
        return  $this->renderAjax('../comment/thread-comment', [
                            'thread_comment' => $thread_comment,
                            'child_comment_form' => new ChildCommentForm()]);
        
    }


    private function setMetaTag($thread_id, $thread_title, $thread_description){
            \Yii::$app->view->registerMetaTag([
                    'property' => 'og:type',
                    'content' => 'website'
            ]);
            \Yii::$app->view->registerMetaTag([
                    'property' => 'og:image',
                    'content' => 'http://www.justbate.com/frontend/web/img/logo_square_share.jpg'
            ]);
            \Yii::$app->view->registerMetaTag([
                    'property' => 'og:url',
                    'content' => LinkConstructor::threadLinkConstructor($thread_id,$thread_title)
            ]);
            \Yii::$app->view->registerMetaTag([
                    'property' => 'og:title',
                    'content' => $thread_title
            ]);
    }


    /**
     * API
     * @return string
     * @throws \yii\base\ExitException
     */
    public function actionSubmitVote() {
        if(!isset($_POST['thread_id']) || !isset($_POST['vote'])) {
            return false;
        }            
        if(Yii::$app->user->isGuest){
            return false;
        }            
        $submit_thread_vote_form  = new SubmitThreadVoteForm();
        $submit_thread_vote_form->user_id = Yii::$app->user->getId();
        $submit_thread_vote_form->thread_id = $_POST['thread_id'];
        $submit_thread_vote_form->choice_text = $_POST['vote'];
        if(!$submit_thread_vote_form->submitVote()){
            Yii::$app->end("Failed to store votes, please try again later ");
        }
        $this->updateThreadView($_POST['thread_id']);

        return true;
    }

    /**
     * @return \yii\web\Response
     */
    public function actionDeleteComment(){
            if(isset($_POST['comment_id'])){
                    $delete_comment_form = new DeleteCommentForm();

                    $delete_comment_form->comment_id = $_POST['comment_id'];

                    if($delete_comment_form->delete()){

                    $thread = Thread::findOne(['thread_id' => $_POST['thread_id']]);

                            return $this->redirect(Yii::$app->request->baseUrl . '/thread/' . $_POST['thread_id'] . '/' . str_replace(' ', '-', strtolower($thread->title)));
                    }
            }
    }

    /**
     * @return \yii\web\Response
     */
    public function actionDeleteThread(){
            if(isset($_POST['thread_id'])){
                    $delete_thread_form = new DeleteThreadForm();

                    $delete_thread_form->thread_id = $_POST['thread_id'];

                    if($delete_thread_form->delete()){
                            return $this->redirect(Yii::$app->request->baseUrl . '/site/home');
                    }
            }
    }

    /**
     * POST DATA: Edit comment form (but only parent id filled), and comment
     * CONCERN: There is a weakness in the redactor that cannot use form to store data
     */
    public function actionEditComment(){
        $edit_comment_form = new EditCommentForm();
        $edit_comment_form->load(Yii::$app->request->post());
        if(isset($_POST['comment']) ){
            $edit_comment_form->comment = $_POST['comment'];
            $edit_comment_form->update();
            $comment_entity = new CommentEntity($edit_comment_form->parent_id, \Yii::$app->user->getId());
            $comment_entity->setComment($edit_comment_form->comment);
            return $this->render('../comment/comment-section', [
                                'thread_comment' => $comment_entity,
                                'edit_comment_form'=> new EditCommentForm()]);
        }
        else{
            Yii::$app->end('error');
        }
    }

    /**
     * @return string
     */
    public function actionEditThread() {
        $edit_thread_form = new EditThreadForm();
        if($edit_thread_form->load(Yii::$app->request->post()) && $edit_thread_form->validate()){
            if(!$edit_thread_form->update()) {
                    //FAIL
            }
        }
        $service = $this->serviceFactory->getService(ServiceFactory::THREAD_SERVICE);
        $thread = $service->getThreadInfo( $edit_thread_form->thread_id,Yii::$app->user->getId(),
                new ThreadVoBuilder());
        $submit_vote_form = new SubmitThreadVoteForm();
        return $this->redirect($thread->getThreadLink());
    }

    /**
     * @param $trigger_id
     * @param $thread_id
     * @return bool
     */
    private function updateCommentNotification($actor_id, $thread_id){
            $notification_form = new NotificationForm();
            $notification_form->actor_id = $actor_id;
            if($notification_form->submitCommentNotification($thread_id) == true){
                    return true;
            }
    }

    private function updateChildCommentNotification($actor_id, $thread_id, $comment_id){
            $notification_form = new NotificationForm();
            $notification_form->actor_id = $actor_id;
            if($notification_form->submitChildCommentNotification($thread_id, $comment_id) == true){
                    return true;
            }

    }

    public function actionRequestAnonymous(){
        if(isset($_POST['thread_id']) && !Yii::$app->user->isGuest){
            $thread_id = $_POST['thread_id'];
            $user_id = Yii::$app->user->getId();

            //bad practice, please remove during refactoring
            $thread_anon_form = new ThreadAnonymousForm();
            $thread_anon_form->thread_id = $thread_id;
            $thread_anon_form->user_id = $user_id;

            $this->updateThreadView($thread_id);

            return $thread_anon_form->requestAnon();
        } else {
            return false;
        }
    }


    public function actionCancelAnonymous(){
        if(isset($_POST['thread_id']) && !Yii::$app->user->isGuest){
            $thread_id = $_POST['thread_id'];
            $user_id = Yii::$app->user->getId();

            //bad practice, please remove during refactoring
            $thread_anon_form = new ThreadAnonymousForm();
            $thread_anon_form->thread_id = $thread_id;
            $thread_anon_form->user_id = $user_id;
            return $thread_anon_form->cancelAnon();
        } else {
            return false;
        }
    }

    private function updateThreadView($thread_id) {
        $thread_view_form = new ThreadViewForm();
        $thread_view_form->user_id = Yii::$app->user->getId();
        $thread_view_form->thread_id = $thread_id;
        $thread_view_form->store();            
    }

}
