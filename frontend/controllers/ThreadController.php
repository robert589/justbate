<?php
namespace frontend\controllers;

use frontend\models\CommentVoteForm;
use frontend\models\SubmitRateThreadForm;
use frontend\models\SubmitThreadVoteForm;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\data\Pagination;

use frontend\models\CommentForm;
use frontend\models\CommentLikeForm;
use frontend\models\ChildCommentForm;
use frontend\models\EditCommentForm;

use common\models\Comment;
use common\models\Thread;
use common\models\ThreadRate;
use common\models\Choice;
use common\models\ChildComment;
use common\models\CommentVote;

use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\SqlDataProvider;
use common\models\ThreadVote;

/**
 * Profile controller
 */
class ThreadController extends Controller
{

    public function actionIndex(){

        Yii::trace( Yii::$app->user->identity);

        if(!empty($_GET['id'])){

            $thread_id = $_GET['id'];
            //thread data
            $thread = Thread::retrieveThreadById($thread_id, \Yii::$app->user->getId());
            $commentModel = new CommentForm();
            //get all thread_choices
            $thread_choice = $this->getChoiceAndItsVoters($thread_id);
            //get all comment providers
            $commentProviders = $this->getAllCommentProviders($thread_id, $thread_choice);
            // get vote mdoels
            $submitVoteModel = new SubmitThreadVoteForm();
            return $this->render('index', ['model' => $thread, 'commentModel' => $commentModel
                                        ,'thread_choice' => $thread_choice, 'submitVoteModel' => $submitVoteModel,
                                            'comment_providers' => $commentProviders]);

        }


        return $this->render('index');
    }


    public function actionGetChildComment(){
        if(isset($_POST['comment_id'])){
            $comment_id = $_POST['comment_id'];
            $result =  ChildCOmment::getAllChildComments($comment_id);

            $child_comment_provider = new \yii\data\ArrayDataProvider([
                'allModels' => $result,
                'pagination' => [
                    'pageSize' => 5,
                ]

            ]);

            $child_comment_form = new ChildCommentForm();

            $this->renderAjax('_child_comment', ['child_comment_provider' => $child_comment_provider, 'comment_id' => $comment_id,
                                                'retrieved' => true, 'child_comment_form' => $child_comment_form]);
        }
        else{
            Yii::$app->end('comment_id not poster');
        }
    }

    /**
     * POST DATA: user_id, parent_id, ChildCommentForm
     * return: render
     */
    public function actionSubmitChildComment(){
        $child_comment_form = new ChildCommentForm();
        if(isset($_POST['user_id'])  && isset($_POST['parent_id'])) {
            $user_id = $_POST['user_id'];
            $parent_id = $_POST['parent_id'];

            $child_comment_form->user_id = $user_id;
            $child_comment_form->parent_id = $parent_id;

            if($child_comment_form->load(Yii::$app->request->post()) && $child_comment_form->validate()){
                if($child_comment_form->store()){
                    $child_comment_form = new ChildCommentForm();

                    $result =  ChildCOmment::getAllChildComments($parent_id);

                    $child_comment_provider = new \yii\data\ArrayDataProvider([
                        'allModels' => $result,
                        'pagination' => [
                            'pageSize' => 5,
                        ]

                    ]);

                    return $this->render('_child_comment', ['comment_id' => $parent_id,
                                'retrieved' => true, 'child_comment_provider' => $child_comment_provider, 'child_comment_form' => $child_comment_form]);
                }
            }
        }
    }


    /**
     * WEAKNESS: If server validation error occur, no solution other than saying error
     * POST DATA: Comment Model;
     */
    public function actionSubmitComment(){
        if(!Yii::$app->user->isGuest){
            $commentModel = new CommentForm();
            if($commentModel->load(Yii::$app->request->post()) && $commentModel->validate() && isset($_POST['thread_id']) ) {
                $thread_id = $_POST['thread_id'];
                $commentModel->thread_id =  $thread_id;
                $commentModel->user_id = \Yii::$app->user->getId();
                if($commentModel->store()){
                    return  $this->redirect(Yii::getAlias('@base-url') . '/thread/index?id=' . $thread_id );
                }
                else{

                }
            }
        }
    }

    /**
     *
     */
    public function actionCommentVote(){
        if(isset($_POST['comment_id']) && isset($_POST['user_id']) && isset($_POST['vote'])){
            $comment_id = $_POST['comment_id'];
            $user_id = $_POST['user_id'];
            $vote = $_POST['vote'];


            $comment_vote_form = new CommentVoteForm();
            $comment_vote_form->user_id = $user_id;
            $comment_vote_form->vote = $vote;
            $comment_vote_form->comment_id =  $comment_id;

            if($comment_vote_form->validate()){

                if($comment_vote_form->store() == true){
                    $comment_votes_comment  = CommentVote::getCommentVotesOfComment($comment_id, $user_id);
                    $total_like  = $comment_votes_comment['total_like'];
                    $total_dislike = $comment_votes_comment['total_dislike'];
                    $vote = $comment_votes_comment['vote'];
                    return $this->renderPartial('_comment_votes', ['total_like' => $total_like, 'total_dislike' => $total_dislike,
                                                        'vote' => $vote, 'comment_id' => $comment_id]);
                }
                else{
                    //error if store fail
                }
            }
            else{
                //error if something is wrong
            }
        }
    }

    /**
     * POST DATA: $_POST['userThreadRate'] and $_POST['thread_id']
     * OTHER DATA: user_id
     * @return bool|string
     */
    public function actionSubmitRate(){
        if(!empty($_POST['userThreadRate']) && !empty($_POST['thread_id'])){
            $userThreadRate = $_POST['userThreadRate'];
            $thread_id = $_POST['thread_id'];
            $rateModel = new SubmitRateThreadForm();
            $rateModel->rate = $userThreadRate;
            $rateModel->thread_id = $thread_id;
            $rateModel->user_id = \Yii::$app->user->getId();

            if(!$rateModel->insertRating()){
                return false;
            }
            else{
                $avg_rating = ThreadRate::getAverageRate($thread_id);

                $total_raters = ThreadRate::getTotalRaters($thread_id);
                 return $this->renderPartial('_submit_rate_pjax', ['thread_id' => $thread_id,'total_raters' => $total_raters, 'avg_rating' => $avg_rating ]);
            }
        }
    }

    /**
     * POST DATA: SubmitThreadVoteForm['choice_text'], thread_id (inserted to submitthreadvoteform)
     * OTHER DATA: user_id (retrieved in controller)
     * WEAKNESS: Query needs to be two times for choice, and user_vote
     * @return string|\yii\web\Response
     */
    public function actionSubmitVote(){

        //only person that is looged in can submit vote
        if(!Yii::$app->user->isGuest){
            $thread_vote_form = new SubmitThreadVoteForm();

            //loading thread_vote_form
            if( (isset($_POST['thread_id'])) && $thread_vote_form->load(Yii::$app->request->post())){
                $thread_id = $_POST['thread_id'];
                $thread_vote_form->thread_id = $thread_id;
                //user id retrieved in controller
                $thread_vote_form->user_id = \Yii::$app->user->getId();
                if($thread_vote_form->submitVote()){
                    //get all thread_choices
                    $thread_choice = $this->getChoiceAndItsVoters($thread_id);
                    $submitVoteModel = new SubmitThreadVoteForm();
                    return $this->renderPartial('_submit_vote_pjax', ['user_choice' => $thread_vote_form->choice_text ,
                                                'submitVoteModel' => $submitVoteModel,
                                                'thread_choice' => $thread_choice,'thread_id' => $thread_id]);
                }
                else{
                    //if the submission fail
                }

            }
        }
        else{
            return $this->redirect(Yii::getAlias('@base-url'. '/site/login'));
        }
    }


    /**Thread Choice */
    private function getChoiceAndItsVoters($thread_id){
        $thread_choice = Choice::getChoiceAndItsVoters($thread_id);

        //Map it in proper way
        return ArrayHelper::map($thread_choice, 'choice_text', 'choice_text_and_total_voters');
    }


    private function getAllCommentProviders($thread_id, $thread_choices){

        //the prev $thread_choice is an associative array, convert to normal array
        //the prev $thread_chocie: e.g  ("agree" : "agree ( 0 voters), " disagree": "disagree (1 voters) " )
        $thread_choices = array_keys($thread_choices);

        //initialize array
        $all_providers = array();

        foreach($thread_choices as $thread_choice){
            //$thread_choice contains the choice of the thread, e.g = "Agree", "Disagree"
            $dataProvider =new ArrayDataProvider([
                                'allModels' => Comment::getCommentByChoiceText($thread_id, $thread_choice),
                                    'pagination' => [
                                    'pageSize' =>10,
                                ],

                            ]);
            $all_providers[$thread_choice] = $dataProvider;
        }

        return $all_providers;
    }


}
