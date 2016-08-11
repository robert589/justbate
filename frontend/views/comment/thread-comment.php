<?php
use yii\helpers\Html;
/** @var $thread_comment \frontend\vo\ThreadCommentVo */

//used variable
$comment_id = $thread_comment->getCommentId();
$current_user_vote = $thread_comment->getCurrentUserVote();
$comment_creator_full_name = $thread_comment->getFullName();
$comment_creator_user_id = $thread_comment->getCommentCreatorId();
$commentator_user_profile_link = $thread_comment->getUserProfileLink();
$commentator_user_photo_path_link = $thread_comment->getCommentCreatorPhotoLink();
$comment_thread_id = $thread_comment->getParentThreadId();
?>

<div class="thread-comment-container">
    <div class="thread-comment-subcontainer">
        <img class="img img-circle profile-picture-comment"
             src="<?= $commentator_user_photo_path_link ?>">
        <div class="commentator-name">
            <?php if($thread_comment->getAnonymous()) { ?>
                <label><?= $comment_creator_full_name ?></label> chose <?= $thread_comment->getChoiceText() ?>
            <?php } else { ?>
                <?= Html::a($comment_creator_full_name ,
                        $commentator_user_profile_link,
                        ['data-pjax' => 0])?>  chose <?= $thread_comment->getChoiceText() ?>
            <?php } ?>
        </div>

    </div>
    <?= $this->render('thread-comment-bottom', ['thread_comment' => $thread_comment, 'is_thread_comment' => true]) ?>
    
</div>
