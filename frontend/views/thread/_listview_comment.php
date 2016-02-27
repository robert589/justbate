<?php

use kartik\rating\StarRating;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ListView;
use yii\bootstrap\Modal;
use frontend\models\EditCommentForm;
use common\models\Comment;
	if(Yii::$app->user->isGuest){
		$guest = 1;
		$belongs = 0;
	}
	else{
			$guest= 0;
		if(Yii::$app->user->getId()== $model['user_id']){
			$belongs = 1;

		}
		else{
			$belongs = 0;
		}
	}

	$comment_id = $model['comment_id'];

?>

<?php
	Modal::begin([
			'header' => '<h4> Edit Comment </h4>',
			'id' => "editModal-$comment_id",
			'size' => 'modal-lg'
		]);


		$redirectFrom = \Yii::$app->homeUrl . '../../thread/index?id=' . $model['thread_id'];
		$editCommentModel = new EditCommentForm();
		$editCommentModel->parent_id = $comment_id;
		$editCommentModel->comment = Comment::getComment($comment_id);
		echo $this->render('../thread/editModal', ['editCommentModel' => $editCommentModel]);

	Modal::end();
?>




<article>
	<div class="box col-md-12" >
		<!--First TOP -->
		<div class="row">
			<!--The name of the person that make the comments -->
			<div class="col-md-6">
				<?= Html::a($model['first_name'] . ' ' . $model['last_name'], Yii::$app->request->baseUrl . "/profile/index?username=" . $model['username'],
						['data-pjax' => 0])?>
			</div>

			<!-- Votes part-->
			<?= $this->render('_comment_votes', [  'comment_id' => $model['comment_id'],
													'vote' => $vote,
													'thread_id' => $model['thread_id'],
													'total_like' => $total_like ,
														'total_dislike' => $total_dislike]) ?>
		</div>

		<div class="row">	
			<?= $model['comment']?>
		</div>

		<?= $this->render('_child_comment', ['guest' => $guest, 'belongs' => $belongs,
											'comment_id' => $model['comment_id'], 'thread_id' => $model['thread_id'],
											'user_id' => $model['user_id'],'child_comment_form' => $child_comment_form ]) ?>

	</div>
	

	<br><br><br><br>


</article>
		

