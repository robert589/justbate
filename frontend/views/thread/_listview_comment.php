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
/** @var $model array */
/** @var $vote integer */
$comment_id = $model['comment_id'];

?>

<article class="block-for-comment">
	<div class="col-xs-1 image-commentator">
		<img class="img img-rounded profile-picture-comment" src="http://www.hit4hit.org/img/login/user-icon-6.png">
	</div>
	<div class="col-xs-11 non-image-commentator">
		<div class="col-xs-12 commentator-name">
			<?= Html::a($model['first_name'] . ' ' . $model['last_name'], Yii::$app->request->baseUrl . "/user/" . $model['username'],
			['data-pjax' => 0])?>
		</div>
		<div class="col-xs-12 comment-created-block">
			<div class="comment-created">xxxx-yy-zz hh:mm:ss</div>
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
		'child_comment_form' => $child_comment_form ]) ?>
	</div>
</article>
<hr>
