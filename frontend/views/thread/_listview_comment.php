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
$comment_id = $model['comment_id'];

?>

<article >
	<div class="col-xs-12" id="commentator-name">
		<!--First TOP -->
		<!--The name of the person that make the comments -->
		<?= Html::a($model['first_name'] . ' ' . $model['last_name'], Yii::$app->request->baseUrl . "/profile/" . $model['username'],
		['data-pjax' => 0])?>
	</div>

	<div class="row">
		<div class="col-xs-6" id="commentator-comment">
			<?= $this->render('_view_edit_comment_part', ['comment' => $model['comment'],
			'edit_comment_form' => new EditCommentForm(),
			'comment_id' => $comment_id]) ?>
		</div>

		<div class="col-xs-6" id="commentator-moderate">
			<div class="col-xs-12">
				<!-- Votes part-->
				<?= $this->render('_comment_votes', [  'comment_id' => $comment_id,
				'vote' => $vote,
				'thread_id' => $model['thread_id'],
				'total_like' => $total_like ,
				'total_dislike' => $total_dislike])
				?>

				<?php if($belongs){ ?>
					<?= Html::button('Edit', ['class' => 'btn btn-primary edit_comment', 'data-service' => $comment_id]) ?>

					<?= Html::button('Delete', ['class' => 'btn btn-danger', 'id' => 'delete_comment_' . $comment_id]) ?>
					<?php } ?>

					<!-- Child commetn and the button, must be started with col-md-6  -->
					<?= $this->render('_child_comment', ['comment_id' => $comment_id,
					'thread_id' => $model['thread_id'],
					'user_id' => $model['user_id'],
					'child_comment_form' => $child_comment_form ]) ?>
				</div>
			</div>
		</div>
</article>
<hr>
