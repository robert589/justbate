<?php

use kartik\rating\StarRating;

use yii\helpers\Html;
use yii\helpers\Url;
      //  Yii::$app->end(print_r($model));

       // $model = $model[0];
?>


	<article>
		<div class="box col-md-12">

			<div class="row">
				<div class="col-md-6">
					<?= Html::a($model['first_name'] . ' ' . $model['last_name'], "#" )?>
				</div>


					<!-- The form only be used as refresh page -->
					<?= Html::beginForm(['thread/index'], 'post', ['id' => 'submitvote-form', 'data-pjax' => '', 'class' => 'form-inline']); ?>

						<?= Html::hiddenInput('vote', null, ['id' => 'vote_result'])?>

						<?= Html::hiddenInput('comment_id', $model['comment_id']) ?>

						<div class="col-md-6">
							<div class="col-md-3">
								<button type="button" class="btn btn-default" style="border:0px solid transparent" onclick="upVote()">
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
								<button  type="button" class="btn btn-default" style="border:0px solid transparent" onclick="downVote()">
									<span align="center"class="glyphicon glyphicon-arrow-down"></span>
						        </button>
							</div>
						</div>
					<?= Html::endForm() ?>


			</div>
			<div class="row">
					<?= $model['comment']?>
			</div>
			
		</div>
			

		<br><br><br>
	<br><br><br><br><br><br><br><br><br>
	</article>


<?php  $this->registerJsFile(Yii::$app->request->baseUrl.'/js/list_comment.js') ?>