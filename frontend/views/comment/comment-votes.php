<?php
//Rendered from: _listview_child_comment
use yii\widgets\Pjax;
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

Pjax::begin([
    'id' => 'comment_likes_' . $comment_id,
    'timeout' => false,
    'enablePushState' => false,
    'options'=>[
        'class' => 'comment_votes_pjax',
        'skipOuterContainers' => true,
        'container'=>'#comment_likes_' . $comment_id,
    ],
]);

?>

<!-- The vote -->
<!-- The form only be used as refresh page -->
<?= Html::beginForm(["thread/comment-vote" ],
                    'post',
                    ['id' => 'submit-vote-form-' . $comment_id,
                     'data-pjax' => '#comment_likes_' . $comment_id,
                     'class' => 'form-inline submit-vote-form']); ?>
    <?= Html::hiddenInput("comment_id", $comment_id, ['class' => 'hi-comment-vote-comment-id']) ?>
    <?= Html::hiddenInput("vote", $vote, ['id' => 'hi-comment-vote-' . $comment_id]) ?>
    <?= Html::hiddenInput("is_thread_comment", $is_thread_comment) ?>
    <?= Html::hiddenInput("user_id",$current_user_login_id) ?>
    <span>
        <?php if($vote_up == true) {  ?>
        <div class="btn-group" id="button-vote-up">
            <?= Html::submitButton($upvote , [
                'id' => "btn_vote_up_" . $comment_id ,
                'class' => 'btn btn-sm btn-default submit-comment-vote-button',
                'value' => 1,
                'disabled' => true])
            ?>
            <button type="button" class="btn btn-sm btn-disabled"><?= $total_like ?></button>
        </div>
        <?php } else { ?>
        <div class="btn-group" id="button-vote-up">
            <?= Html::submitButton($upvote , [
                'id' => "btn_vote_up_" . $comment_id ,
                'class' => 'btn btn-sm btn-default submit-comment-vote-button',
                'value' => 1
            ]) ?>
            <button type="button" class="btn btn-sm btn-disabled"><?= $total_like ?></button>
        </div>
        <?php } ?>
    </span>
    <span>
        <?php if($vote_down) {  ?>
            <div class="btn-group" id="button-vote-down">
                <?= Html::submitButton($downvote , [
                    'id' => "btn_vote_down_" . $comment_id ,
                    'class' => 'btn btn-sm btn-default submit-comment-vote-button',
                    'value' => -1,
                    'disabled' => true
                ]) ?>
                <button type="button" class="btn btn-sm btn-disabled"><?= $total_dislike ?></button>
            </div>
        <?php } else { ?>
            <div class="btn-group" id="button-vote-down">
                <?= Html::submitButton($downvote , [
                    'id' => "btn_vote_down_" . $comment_id ,
                    'value' => -1,
                    'class' => 'btn btn-sm btn-default submit-comment-vote-button',
                ]) ?>
                <button type="button" class="btn btn-sm btn-disabled"><?= $total_dislike ?></button>
            </div>
        <?php } ?>
    </span>
<?= Html::endForm() ?>
<?php Pjax::end(); ?>
