<?php
use yii\helpers\HtmlPurifier;
use common\components\Constant;
use yii\helpers\Html;
/** @var $thread \frontend\vo\ThreadVo */
/** @var $thread_issues array */
$link_to_thread = $thread->getThreadLink();
$thread_title = $thread->getTitle();
$thread_description = $thread->getDescription();
$thread_id = $thread->getThreadId();
$thread_issues = $thread->getThreadIssues();
$comment_request_url = $thread->getCommentRequestUrl();
$has_chosen_comment = $thread->hasChosenComment();
$has_another_comment = (($thread->getTotalComments() - 1) > 0);
?>

<div data-service="<?= $thread_id ?>" class="list-thread">
    <div class="col-xs-12" id="thread-issue">
            <?= $this->render('../thread/thread-issues', ['thread' => $thread]) ?>
    </div>
    <div class="col-xs-12 thread-view">
        <div class="col-xs-12 thread-link" align="left">
            <div class="col-xs-12">
                <?= Html::a(Html::encode($thread_title), $link_to_thread)?>
            </div>
        </div>
        <div class="col-xs-12" align="left">
            <div class="col-xs-12">
                <?= HtmlPurifier::process($thread_description, Constant::DefaultPurifierConfig()) ?>
            </div>
        </div>
        <div class="col-xs-12 home-thread-list-vote" align="center" >
            <div class="col-xs-12">
            
            <?= $this->render('../thread/thread-vote',
                    ['thread' => $thread,
                     'submit_thread_vote_form' => new \frontend\models\SubmitThreadVoteForm()])?>
            </div>
        </div>
         <div class="user-comment-reaction col-xs-12">
            <div class="home-comment-tab">
                    <?= $this->render('home-thread-list-bottom', ['thread' => $thread]) ?>
            </div>
            <?php if($has_chosen_comment){
                $chosen_comment = $thread->getChosenComment();
                $commentator_user_profile_link = $chosen_comment->getUserProfileLink();
                $commentator_user_profile_pic_link = $chosen_comment->getCommentCreatorPhotoLink();
                $commentator_choice = $chosen_comment->getCurrentUserVote();
                $commentator_full_name = $chosen_comment->getFullName();
                $comment  = $chosen_comment->getComment();
            ?>
            <div class="col-xs-12">
                <?= $this->render('../comment/thread-comment', ['thread_comment' => $chosen_comment]) ?>
            </div>
            <div class="col-xs-12">
                <?php if($has_another_comment) { ?>
                    <?= Html::a('View all comments <span class="glyphicon glyphicon-arrow-right"></span>', $link_to_thread, ['target' => '_blank']) ?>
                <?php } ?>
            </div>
            <?php
                }
            ?>
            </div>
    </div>
</div>
