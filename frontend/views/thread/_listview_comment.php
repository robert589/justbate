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
/** @var $model array */
/** @var $vote integer */
/** @var $total_like integer */
/** @var $total_dislike integer
/**  @var $comment_id integer */
/** @var $child_comment_form \frontend\models\ChildCommentForm */
$comment_id = $model['comment_id'];
?>

<article class="block-for-comment">
	<div class="col-xs-1 image-commentator">
		<?php if(isset($model['photo_path'])){ ?>

			<img class="img img-rounded profile-picture-comment" src=<?= Yii::getAlias('@image_dir') . '/' . $model['photo_path'] ?>>

		<?php } ?>
	</div>

	<div class="col-xs-11 non-image-commentator">
		<div class="col-xs-12 commentator-name">
			<?= Html::a($model['first_name'] . ' ' . $model['last_name'], Yii::$app->request->baseUrl . "/user/" . $model['username'],
			['data-pjax' => 0])?>
		</div>
		<div class="col-xs-12 comment-created-block">
			<div class="comment-created"><?= DateTimeFormatter::getTimeByTimestampAndOffset($model['created_at']) ?></div>
		</div>
	</div>

	<div class="col-xs-12 commentator-moderate">
		<div class="col-xs-12 commentator-comment">
			<?= $this->render('_view_edit_comment_part', ['comment' => $model['comment'],
							'edit_comment_form' => new EditCommentForm(),
							'comment_id' => $comment_id]) ?>
		</div>

		<div class="col-xs-4" class="comment-votes">
			<!-- Votes part-->
			<?= $this->render('_comment_votes', [  'comment_id' => $comment_id,
												'vote' => $vote,
												'thread_id' => $model['thread_id'],
												'total_like' => $total_like ,
												'total_dislike' => $total_dislike])
			?>

		</div>

		<!-- Child commetn and the button, must be started with col-md-6  -->
		<?= $this->render('_child_comment', ['comment_id' => $comment_id,
											'thread_id' => $model['thread_id'],
											'user_id' => $model['user_id'],
											'belongs' => (Yii::$app->user->getId() == $model['user_id']),
											'retrieved' => false,
											'child_comment_form' => $child_comment_form ]) ?>
	</div>

</article>