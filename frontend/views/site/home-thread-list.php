<?php
use common\widgets\SimpleSeeMore;
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
    <div  id="thread-issue">
            <?= $this->render('../thread/thread-issues', ['thread' => $thread]) ?>
    </div>
    <div class="thread-view">
        <div class=" thread-link" align="left">
            <?= Html::a(Html::encode($thread_title), $link_to_thread)?>
        </div>
        <div class="thread-description" align="left">
            <?= SimpleSeeMore::widget(['text' => $thread_description, 'active' => true, 
                'id' => 'home-thread-list-description-' . $thread_id]) ?>
        </div>
        <div class="home-thread-list-vote" align="center" >
            <?= $this->render('../thread/thread-vote',
                    ['thread' => $thread,
                     'submit_thread_vote_form' => new \frontend\models\SubmitThreadVoteForm()])?>
        </div>
        <div class="home-comment-tab">
                <?= $this->render('home-thread-list-bottom', ['thread' => $thread]) ?>
        </div>
        <div class="home-thread-list-chosen-comment">
        <?php if($has_chosen_comment){
            $chosen_comment = $thread->getChosenComment();
            $commentator_user_profile_link = $chosen_comment->getUserProfileLink();
            $commentator_user_profile_pic_link = $chosen_comment->getCommentCreatorPhotoLink();
            $commentator_choice = $chosen_comment->getCurrentUserVote();
            $commentator_full_name = $chosen_comment->getFullName();
            $comment  = $chosen_comment->getComment();
            $comment_id = $chosen_comment->getCommentId();
        ?>
            <?= frontend\widgets\BlockThreadComment::widget(['id' => 'home-thread-list-block-' . $comment_id, 'thread_comment' => $chosen_comment]) ?>

        <?php
            }
        ?>
        </div>
    </div>
</div>
