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

    <br>

    <div class="col-md-12" style="max-height: 35px">

        <div class="inline" style="margin-left: 15px">
            <img class="img img-rounded profile-picture-comment" style="height:35px;width:35px" src=<?= $commentator_user_photo_path_link ?>>
        </div>

        <div class="inline" style="margin-left: 15px" id="commentator-name">
            <?= Html::a("<b>" .Html::encode($comment_creator_full_name) .  "</b>", $commentator_user_profile_link )?>
        </div>

        <div  style="margin-left: 10px" class="inline" id="commentator-moderate">
            <?= $this->render('_comment_votes', ['comment' => $child_comment, 'is_thread_comment' => false]) ?>
        </div>

    </div>

    <div class="col-md-12">

        <div style="margin-left:10px" align="left" id="commentator-comment">
            <?= $comment ?>
        </div>

    </div>

</article>
