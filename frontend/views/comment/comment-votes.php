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
$current_user_login_id = $comment->getCurrentUserLoginId();

if(($is_thread_comment)){
    $upvote = "<span class='glyphicon glyphicon-thumbs-up'></span>";
    $downvote = "<span class='glyphicon glyphicon-thumbs-down'></span>";
}
else{
    $upvote = "<span class='glyphicon glyphicon-chevron-up'></span>";
    $downvote = "<span class='glyphicon glyphicon-chevron-down'></span>";
}
?>
<div id="comment-vote-section-<?= $comment_id ?>">
    <?= Html::hiddenInput('comment-vote-old-value', $vote, ['class' => 'comment-vote-old-value']) ?>
    <span class="btn-group comment-vote-up-section">
        <?php if($vote_up == true) {  ?>
            <?= Html::button($upvote , [
                'id' => "comment-vote-button-up-" . $comment_id ,
                'class' => 'btn btn-sm btn-default comment-vote-button',
                'value' => 1,
                'data-arg' => $comment_id,
                'disabled' => true])
            ?>
        <?php } else { ?>
            <?= Html::button($upvote , [
                'id' => "comment-vote-button-up-" . $comment_id ,
                'class' => 'btn btn-sm btn-default comment-vote-button',
                'data-arg' => $comment_id,
                'value' => 1
            ]) ?>
        <?php } ?>
        <button type="button" class="btn btn-sm btn-disabled comment-vote-total"><?= $total_like ?></button>
    </span>
    <span class="btn-group comment-vote-down-section">
        <?php if($vote_down) {  ?>
            <?= Html::button($downvote , [
                'id' => "comment-vote-button-down" . $comment_id ,
                'class' => 'btn btn-default btn-sm comment-vote-button',
                'value' => -1,
                'data-arg' => $comment_id,
                'disabled' => true
            ]) ?>
        <?php } else { ?>
            <?= Html::button($downvote , [
                'id' => "comment-vote-button-down" . $comment_id ,
                'value' => -1,
                'data-arg' => $comment_id,
                'class' => 'btn btn-default btn-sm comment-vote-button',
            ]) ?>
        <?php } ?>
        <button type="button" class="btn btn-disabled btn-sm comment-vote-total"><?= $total_dislike ?></button>
    </span>
</div>