<?php
//Rendered from: _listview_child_comment
use yii\helpers\Html;
/** @var $comment \common\entity\CommentEntity */
/** @var $is_thread_comment boolean */
$total_like = $comment->getTotalLike();
$comment_id = $comment->getCommentId();
$total_dislike = $comment->getTotalDislike();
$vote = $comment->getCurrentUserVote();
$vote_up = ($vote == 1);
$vote_down = ($vote == -1);

?>
<div id="<?= $id ?>" class="comment-votes-container">
    <span class="comment-votes-total-like">
        <?= $total_like ?>
    </span>
    <?= Html::button('<span class="glyphicon glyphicon-arrow-up"></span>',[
        'class' => 'button-like-link comment-votes-button comment-votes-button-up',
        'value' => 1,
        'data-id' => $id,
        'data-comment_id' => $comment_id,
        'style' => 'margin-right: 10px;',
        'disabled' => $vote_up]); ?>
    
    <span class="comment-votes-total-dislike">
        <?= $total_dislike ?>
    </span>
    <?= Html::button('<span class="glyphicon glyphicon-arrow-down"></span>', [
        'class' => 'button-like-link comment-votes-button comment-votes-button-down',
        'value' => -1,
        'data-id' => $id,
        'data-comment_id' => $comment_id,
        'disabled' => $vote_down]); ?>
    
    <?= Html::hiddenInput('comment-votes-old-value', $vote, 
            ['class' => 'comment-votes-old-value']) ?>
</div>
