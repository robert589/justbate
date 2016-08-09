<?php
use common\widgets\SimpleSeeMore;
use yii\helpers\Html;
use frontend\widgets\ThreadVoteComment;
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
        <?=  ThreadVoteComment::widget(['id' => 'home-thread-list-vote-' . $thread_id, 'thread' => $thread]) ?>        
        <div class="home-thread-list-chosen-comment">
        <?php if($has_chosen_comment){
            $chosen_comment = $thread->getChosenComment();
            $comment_id = $chosen_comment->getCommentId();
        ?>
            <?= frontend\widgets\BlockThreadComment::widget(['id' => 'home-thread-list-block-' . $comment_id, 'thread_comment' => $chosen_comment]) ?>

        <?php } ?>
        </div>
    </div>
</div>
