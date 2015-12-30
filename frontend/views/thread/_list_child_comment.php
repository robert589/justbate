<?php

use kartik\rating\StarRating;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ListView;

?>

<br>
<article>
	<div class="box col-md-12">

		<div class="row">
			<div class="col-md-6">
				<?= Html::a($model['first_name'] . ' ' . $model['last_name'], "#" )?>
			</div>

			<?php $comment_id = $model['comment_id'];
				$vote = null;
				Pjax::begin([
						        'clientOptions'=>[
						        	'timeout' => 5000,
						            'container'=>'w1' . $comment_id,
								]
							]); ?>

				<!-- The form only be used as refresh page -->
				<?= Html::beginForm(["../../thread/index?id=" . $model['thread_id']  ], 'post', ['id' => 'submitvote-form-' . $comment_id, 'data-pjax' => 'w1' . $comment_id, 'class' => 'form-inline']); ?>

					<?= Html::hiddenInput("vote", $model['vote'], ['id' => "vote_result_$comment_id"])?>

					<?= Html::hiddenInput("comment_id", $comment_id, ['id' => 'comment_id']) ?>

					<?php $voteUp = ($model['vote'] == 1) ? 'disabled' : false;
						$voteDown = ($model['vote'] == -1) ? 'disabled' : false;
						?>
					<div class="col-md-6">
						<div class="col-md-3">
							<button type="button" <?php if($voteUp) echo 'disabled' ?> class="btn btn-default" style="border:0px solid transparent" onclick="$('#vote_result_'+ <?=$comment_id?>).val(1);  
					     																								$('#submitvote-form-'+ <?=$comment_id?>	).submit();	">
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
							<button  type="button" <?php if($voteDown) echo 'disabled' ?> class="btn btn-default" style="border:0px solid transparent" onclick=" $('#vote_result_'+ <?=$comment_id?>).val(-1);  
					     																								$('#submitvote-form-'+ <?=$comment_id?>	).submit();	">
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

		<hr>
	<br><br><br><br>
</article>



