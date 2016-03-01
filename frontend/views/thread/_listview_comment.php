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

<article >
	<div class="col-md-12" style="border-bottom: 1px silver" >
		<!--First TOP -->
		<div class="row name_link" align="left">
			<!--The name of the person that make the comments -->
			<?= Html::a($model['first_name'] . ' ' . $model['last_name'], Yii::$app->request->baseUrl . "/profile/index?username=" . $model['username'],
					['data-pjax' => 0])?>
		</div>

		<div class="row" style="min-height: 50px">
			<div align="left">
				<?= $model['comment']?>
			</div>
		</div>


		<div class="row" >
			<div class="col-md-6" style="margin-bottom: 10px">
				<div class="col-md-7">
					<!-- Votes part-->
					<?= $this->render('_comment_votes', [  'comment_id' => $model['comment_id'],
						'vote' => $vote,
						'thread_id' => $model['thread_id'],
						'total_like' => $total_like ,
						'total_dislike' => $total_dislike]) ?>
				</div>
			</div>

			<?= $this->render('_child_comment', ['guest' => $guest, 'belongs' => $belongs,
				'comment_id' => $model['comment_id'], 'thread_id' => $model['thread_id'],
				'user_id' => $model['user_id'],'child_comment_form' => $child_comment_form ]) ?>

		</div>

	</div>

	<hr>

	<br><br><br><br>


</article>
