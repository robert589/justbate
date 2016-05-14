<?php
//Rendered from: _listview_child_comment
use yii\widgets\Pjax;
use yii\helpers\Html;

/** @var $vote */
if(!isset($total_like)){
    $total_like = 0;
}
if(!isset($total_dislike)){
    $total_dislike = 0;
}

$vote_up = ($vote == 1);
$vote_down = ($vote == -1);

Pjax::begin([
    'id' => 'comment_likes_' . $comment_id,
    'timeout' => false,
    'enablePushState' => false,
    'clientOptions'=>[
        'container'=>'#comment_likes_' . $comment_id,
    ]
]);

?>

<!-- The vote -->
<!-- The form only be used as refresh page -->
<?= Html::beginForm(["thread/comment-vote" ], 'post', [
    'id' => 'submit-vote-form-' . $comment_id,
    'data-pjax' => '#comment_likes_' . $comment_id,
    'class' => 'form-inline submit-vote-form']); ?>

    <?= Html::hiddenInput("comment_id", $comment_id, ['class' => 'hi-comment-vote-comment-id']) ?>

    <?= Html::hiddenInput("vote", $vote, ['id' => 'hi-comment-vote-' . $comment_id]) ?>

    <?= Html::hiddenInput("user_id", Yii::$app->user->getId()) ?>

    <span>
        <?php if($vote_up == true) {  ?>
            <div class="btn-group" id="button-vote-up">
                <?= Html::submitButton("<span class='glyphicon glyphicon-thumbs-up'></span>" , [
                    'id' => "btn_vote_up_" . $comment_id ,
                    'class' => 'btn btn-default submit-comment-vote-button',
                    'value' => 1,
                    'disabled' => true])
                ?>
                <button type="button" class="btn btn-disabled"><?= $total_like ?></button>
            </div>
        <?php } else { ?>
            <div class="btn-group" id="button-vote-up">
                <?= Html::submitButton("<span class='glyphicon glyphicon-thumbs-up'></span>" , [
                    'id' => "btn_vote_up_" . $comment_id ,
                    'class' => 'btn btn-default submit-comment-vote-button',
                    'value' => 1
                ]) ?>
                <button type="button" class="btn btn-disabled"><?= $total_like ?></button>
            </div>
        <?php } ?>

    </span>

    <span>
        <?php if($vote_down) {  ?>
            <div class="btn-group" id="button-vote-down">
                <?= Html::submitButton("<span class='glyphicon glyphicon-thumbs-down'></span>" , [
                    'id' => "btn_vote_down_" . $comment_id ,
                    'class' => 'btn btn-default submit-comment-vote-button',
                    'value' => -1,
                    'disabled' => true
                ]) ?>
                <button type="button" class="btn btn-disabled"><?= $total_dislike ?></button>
            </div>
        <?php } else { ?>
            <div class="btn-group" id="button-vote-down">
                <?= Html::submitButton("<span class='glyphicon glyphicon-thumbs-down'></span>" , [
                    'id' => "btn_vote_down_" . $comment_id ,
                    'value' => -1,
                    'class' => 'btn btn-default submit-comment-vote-button',
                ]) ?>
                <button type="button" class="btn btn-disabled"><?= $total_dislike ?></button>
            </div>
        <?php } ?>
    </span>
<?= Html::endForm() ?>
<?php Pjax::end(); ?>
