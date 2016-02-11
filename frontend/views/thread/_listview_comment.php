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
	//Store this variable for javascript
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
				<?= Html::a($model['first_name'] . ' ' . $model['last_name'], Yii::$app->homeUrl . "../../profile/index?username=" . $model['username'] )?>
			</div>	

			<!--The vote name-->
			<?php 
				$vote = null;
				Pjax::begin([
							'id' => 'comment-main-' . $comment_id,
					       	'timeout' => 5000,
			
					        'clientOptions'=>[
					            'container'=>'w1' . $comment_id,
							]
			]); ?>


				<!-- The vote -->
				<!-- The form only be used as refresh page -->
				<?= Html::beginForm(["../../thread/index?id=" . $model['thread_id']  ], 'post', ['id' => 'submitvote-form-' . $comment_id, 'data-pjax' => 'w1' . $comment_id, 'class' => 'form-inline']); ?>

					<?= Html::hiddenInput("vote", $model['vote'], ['id' => "vote_result_$comment_id"])?>

					<?= Html::hiddenInput("comment_id", $comment_id, ['id' => 'comment_id']) ?>

					<?php $voteUp = ($model['vote'] == 1) ? 'disabled' : false;
						$voteDown = ($model['vote'] == -1) ? 'disabled' : false;
					?>

					<div class="col-md-6">
						<div class="col-md-3">
							<button id="btnVoteUp-<?=$comment_id?>" type="button" <?php if($voteUp) echo 'disabled' ?> class="btn btn-default" style="border:0px solid transparent" >
								<span class="glyphicon glyphicon-arrow-up"></span>
							</button>
						</div>
						<div class="col-md-3">
							+<?= $model['total_like'] ?>
						</div>
						<div class="col-md-3">
							-<?= $model['total_dislike'] ?>
						</div>
						<div class="col-md-3">
							<button  type="button" id="btnVoteDown-<?=$comment_id?>" <?php if($voteDown) echo 'disabled' ?> class="btn btn-default" style="border:0px solid transparent">
								<span align="center"class="glyphicon glyphicon-arrow-down"></span>
							</button>
						</div>

					</div>

			<?= Html::endForm() ?>

			<?php Pjax::end(); ?>
		</div>

		<div class="row">	
			<?= $model['comment']?>
		</div>

		<?= $this->render('_child_comment', ['guest' => $guest, 'belongs' => $belongs,
											'comment_id' => $model['comment_id'], 'thread_id' => $model['thread_id'],
											'user_id' => $model['user_id'],'child_comment_form' => $child_comment_form ]) ?>

	</div>
	

	<br><br><br>
<br><br><br><br><br><br><br><br><br>


</article>
		

