<?php

use yii\widgets\Pjax;
use yii\helpers\Html;

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
<?= Html::beginForm(["thread/comment-vote" ], 'post', ['id' => 'submitvote-form-' . $comment_id, 'data-pjax' => '#comment_likes_' . $comment_id, 'class' => 'form-inline']); ?>

    <?= Html::hiddenInput("comment_id", $comment_id) ?>
    <?= Html::hiddenInput("user_id", Yii::$app->user->getId()) ?>

    <?php if($vote_up == true) {  ?>
        <span>
            <?= Html::submitButton("<span class='glyphicon glyphicon-thumbs-up'></span>(+" . $total_like. ")" , [
                'id' => "btn_vote_up_" . $comment_id ,
                'class' => 'btn btn-default',
                'name' => 'vote',
                'value' => 1,
                'disabled' => true])
            ?>
    <?php } else { ?>
            <?= Html::submitButton("<span class='glyphicon glyphicon-thumbs-up'></span>(+" . $total_like. ")" , [
                'id' => "btn_vote_up_" . $comment_id ,
                'class' => 'btn btn-default',
                'name' => 'vote',
                'value' => 1
            ]) ?>
    <?php } ?>

    <?php if($vote_down) {  ?>
            <?= Html::submitButton("<span class='glyphicon glyphicon-thumbs-down'></span> (-" . $total_dislike. ")" , [
                'id' => "btn_vote_down_" . $comment_id ,
                'class' => 'btn btn-default',
                'name' => 'vote',
                'value' => -1,
                'disabled' => true
            ]) ?>
    <?php } else { ?>
            <?= Html::submitButton("<span class='glyphicon glyphicon-thumbs-down'></span> (-" . $total_dislike. ")", [
                'id' => "btn_vote_down_" . $comment_id ,
                'class' => 'btn btn-default',
                'name' => 'vote',
                'value' => -1
            ]) ?>
    <?php } ?>
        </span>

    <?= Html::endForm() ?>
<?php Pjax::end(); ?>
