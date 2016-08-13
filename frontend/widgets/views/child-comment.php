<?php
use yii\helpers\Html;
use frontend\widgets\CommentVotes;
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
<div id="<?= $id ?>" class="child-comment-container <?= $class ?>">
    <div class="child-comment-subcontainer">
        <img class="img img-rounded child-comment-profile-picture" src=<?= $commentator_user_photo_path_link ?>>
        <div class="child-comment-name">
            <?php if(!$anonymous) { ?>
                <?= Html::a("<b>" .Html::encode($comment_creator_full_name) .  "</b>", $commentator_user_profile_link )?>
            <?php } else { ?>
                <b> <?= Html::encode($comment_creator_full_name) ?>  </b>
            <?php } ?>
            
        </div>            
        <span>
            <?= CommentVotes::widget(['comment' => $child_comment, 
                'id' => 'child-comment-votes-' . $comment_id]); ?>
        </span>
        <span style="margin-left: 8px">
            <?= $comment_created_at ?>
        </span>
    </div>
    <div class="child-comment-comment">
        <?= $comment ?>
    </div>

    <?php if ($belongs_to_current_user) { ?>
        <div class="col-xs-12 child-comment-hide child-comment-action-wrapper" id="<?= $comment_id ?>">
            <textarea cols="1"></textarea>
            <button type="submit" class="btn reply-button btn-primary child-comment-input-box-submit-button">Reply</button><br />
            <span class="child-comment-action edit-child-comment">Edit</span>
            <span class="child-comment-action delete-child-comment">Delete</span>
        </div>
    <?php } ?>
</div>
