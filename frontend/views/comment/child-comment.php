<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ListView;
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
?>

<article>
    <div class="col-xs-12" style="margin-bottom:10px">
        <div class="inline">
            <img class="img img-rounded profile-picture-comment" style="height:35px;width:35px" src=<?= $commentator_user_photo_path_link ?>>
        </div>
        <div class="inline commentator-name" style="margin-left: 15px" >
            <?= Html::a("<b>" .Html::encode($comment_creator_full_name) .  "</b>", $commentator_user_profile_link )?>
        </div>
        <div  style="margin-left: 10px" class="inline" class="commentator-moderate">
            <?= $this->render('child-comment-votes', ['comment' => $child_comment, 'is_thread_comment' => false]) ?>
        </div>
    </div>
    <div class="col-xs-12">
        <div align="left" class="commentator-comment">
            <?= $comment ?>
        </div>
    </div>
</article>
