<?php
use kartik\rating\StarRating;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ListView;
use yii\bootstrap\Modal;
use frontend\models\EditCommentForm;
use common\models\Comment;
use yii\widgets\ActiveForm;
use common\components\DateTimeFormatter;
/** @var $thread_comment \common\entity\ThreadCommentEntity */

//used variable
$comment_id = $thread_comment->getCommentId();
$current_user_vote = $thread_comment->getCurrentUserVote();
$comment_creator_full_name = $thread_comment->getFullName();
$comment_creator_user_id = $thread_comment->getCommentCreatorId();
$commentator_user_profile_link = $thread_comment->getCommentatorUserProfileLink();
$commentator_user_photo_path_link = $thread_comment->getCommentatorPhotoLink();
$comment_created_at = $thread_comment->getDateCreated();
$comment_thread_id = $thread_comment->getThreadId();
?>

<article class="block-for-comment">
	<div class="col-xs-1 image-commentator">
		<img class="img img-rounded profile-picture-comment" src=<?= $commentator_user_photo_path_link ?>>
	</div>

	<div class="col-xs-11 non-image-commentator">
		<div class="col-xs-12 commentator-name">
			<span><?= Html::a($comment_creator_full_name, $commentator_user_profile_link, ['data-pjax' => 0])?></span> -
			<span class="comment-created"><?= $comment_created_at ?></span>
		</div>
	</div>

	<div class="col-xs-12 commentator-moderate">
		<?= $this->render('_listview_comment_bottom', ['thread_comment' => $thread_comment, 'is_thread_comment' => true]) ?>
	</div>

</article>
