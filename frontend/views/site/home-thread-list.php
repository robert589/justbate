<?php
use common\widgets\SimpleSeeMore;
use yii\helpers\Html;
use frontend\widgets\ThreadVoteComment;
use frontend\widgets\ThreadSectionBottom;
use frontend\models\SubmitThreadVoteForm;
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
$submit_vote_form = new SubmitThreadVoteForm();
?>

<div data-service="<?= $thread_id ?>" class="list-thread">
    
    <div class="home-thread-list-view">
        <?= $this->render('../thread/thread-section',
            ['thread' => $thread , 'site' => true,  
             'edit_thread_form' => new \frontend\models\EditThreadForm(),
             'submit_vote_form' => $submit_vote_form]); ?>
    
        <?= ThreadSectionBottom::widget(['id' => 'thread-section-bottom-' . $thread_id,
                            'thread' => $thread]) ?>        
        
    </div>
    <?php if($has_chosen_comment){
            $chosen_comment = $thread->getChosenComment();
            $comment_id = $chosen_comment->getCommentId();
        ?>
    <div class="home-thread-list-chosen-comment">

            <?= $this->render('../comment/thread-comment',[ 
                'thread_comment' => $chosen_comment]) ?>

    </div>
    <?php } ?>
    
</div>
