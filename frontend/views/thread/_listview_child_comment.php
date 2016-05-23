<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ListView;
/** @var $child_comment \common\entity\ChildCommentEntity **/


$comment_id = $child_comment->getCommentId();
$guest = Yii::$app->user->isGuest;
$belongs_to_current_user = $child_comment->isBelongToCurrentUser();
$comment_creator_full_name = $child_comment->getFullName();
$comment_creator_user_id = $child_comment->getCommentCreatorId();
$commentator_user_profile_link = $child_comment->getCommentatorUserProfileLink();
$commentator_user_photo_path_link = $child_comment->getCommentatorPhotoLink();
$comment_created_at = $child_comment->getDateCreated();
$comment = Html::encode($child_comment->getComment());

?>

<article>
    <div class="col-xs-3">
        <img class="img img-rounded profile-picture-comment" src=<?= $commentator_user_photo_path_link ?>>
    </div>
    <div class="col-xs-9">

        <div class="col-xs-12" id="commentator-name">
           <?= Html::a(Html::encode($comment_creator_full_name), $commentator_user_profile_link )?>
        </div>

        <div class="col-xs-12" id="commentator-comment">
           <?= $comment ?>
        </div>

        <div class="col-xs-12" id="commentator-moderate">
           <?= $this->render('_comment_votes', ['comment' => $child_comment]) ?>
        </div>
    </div>
</article>
