<?php
use yii\helpers\Html;
/** @var $child_comment \frontend\vo\ChildCommentVo **/


$comment_id = $child_comment->getCommentId();
$guest = Yii::$app->user->isGuest;
$belongs_to_current_user = $child_comment->isBelongToCurrentUser();
$comment_creator_full_name = $child_comment->getFullName();
$comment_creator_user_id = $child_comment->getCommentCreatorId();
$commentator_user_profile_link = $child_comment->getUserProfileLink();
$commentator_user_photo_path_link = $child_comment->getCommentCreatorPhotoLink();
$comment_created_at = $child_comment->getCreatedAt();
$comment = Html::encode($child_comment->getComment());
$anonymous = $child_comment->getAnonymous();
?>
<div id="<?= $id ?>" class="child-comment-container">
    <div class="col-xs-12" style="margin-bottom:10px">
        <div class="inline">
            <img class="img img-rounded profile-picture-comment" src=<?= $commentator_user_photo_path_link ?>>
        </div>
        <div class="inline commentator-name" style="margin-left: 15px" >
            <?php if(!$anonymous) { ?>
                <?= Html::a("<b>" .Html::encode($comment_creator_full_name) .  "</b>", $commentator_user_profile_link )?>
            <?php } else { ?>
                <b> <?= Html::encode($comment_creator_full_name) ?>  </b>
            <?php } ?>
        </div>
        <div class="inline" style="margin-left: 10px" class="commentator-moderate">
            <?= $this->render('child-comment-votes', ['comment' => $child_comment, 'is_thread_comment' => false]) ?>
        </div>
    </div>
    <div class="col-xs-12">
        <div align="left" class="commentator-comment">
            <?= $comment ?>
        </div>
    </div>
</div>
