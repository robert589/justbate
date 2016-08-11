<?php
//Rendered from: _listview_child_comment
use yii\helpers\Html;
/** @var $comment \common\entity\CommentEntity */
/** @var $is_thread_comment boolean */
$total_like = $child_comment->getTotalLike();
$comment_id = $child_comment->getCommentId();
$total_dislike = $child_comment->getTotalDislike();
$vote = $child_comment->getCurrentUserVote();
$vote_up = ($vote == 1);
$vote_down = ($vote == -1);
$current_user_login_id = $child_comment->getCurrentUserLoginId();

?>
<div id="<?= $id ?>" class="child-comment-votes-container">
    <span class="child-comment-votes-total-like">
        <?= $total_like ?>
    </span>
    <?= Html::submitButton('<span class="glyphicon glyphicon-arrow-up"></span>',[
        'class' => 'button-like-link submit-comment-vote-button',
        'value' => 1,
        'style' => 'margin-right: 10px;',

        'disabled' => $vote_up]); ?>
    
    <span class="child-comment-votes-total-dislike">
        <?= $total_dislike ?>
    </span>
    <?= Html::submitButton('<span class="glyphicon glyphicon-arrow-down"></span>', [
        'class' => 'button-like-link submit-comment-vote-button',
        'value' => -1,
        'disabled' => $vote_down]); ?>
    
</div>
