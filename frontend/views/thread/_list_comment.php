<?php

use kartik\rating\StarRating;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ListView;


?>


<article>
	<div class="box col-md-12">

		<div class="row">
			<div class="col-md-6">
				<?= Html::a($model['first_name'] . ' ' . $model['last_name'], Yii::$app->homeUrl . "../../profile/index?id=" . $model['user_id'] )?>
			</div>

			<?php $comment_id = $model['comment_id'];
				$vote = null;
				Pjax::begin([
								'id' => 'comment-main-' . $comment_id,
						       	'timeout' => 5000,

						        'clientOptions'=>[
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
			
			
			<?php Pjax::begin([
				'id' => 'childCommentData-'.$comment_id,
		    	'timeout' => false,
		    	'enablePushState' => false,
				'clientOptions'=>[
				    	'container' => '#childCommentData-' . $comment_id,

				    	'linkSelector'=>'#retrieveComment'.$comment_id
						]
				]);?>
				<div id = "childCommentData-<?=$comment_id?>" class="row">

					<div id="selector"align="right">
					<?= Html::a('Retrieve Comment', ["../../thread/index?id=" . $model['thread_id'] . "&comment_id=" . $comment_id], 
												['data-pjax' => '#childCommentData-'.$comment_id, 'class' => 'btn btn-default'
												,'id' => 'retrieveComment' . $comment_id]) ?>
					</div>
					<div  class="col-md-12">

						<?php if(isset($retrieveChildData)){ ?>
							<?= ListView::widget([

									'dataProvider' => $retrieveChildData,
									'options' => [
										'tag' => 'div',
										'class' => 'list-wrapper',
											'id' => 'list-wrapper',
									],
					    				'layout' => "\n{items}\n{pager}",

									'itemView' => function ($model, $key, $index, $widget) {
										return $this->render('_list_child_comment',['model' => $model]);
									}, 
									'pager' => [
						       	 		'firstPageLabel' => 'first',
						        		'lastPageLabel' => 'last',
						        		'nextPageLabel' => 'next',
						        		'prevPageLabel' => 'previous',
						        		'maxButtonCount' => 3,
									],
								]) ?>

						<?php } ?>
						

					</div>
			</div>
			<?php Pjax::end();?>
		
	</div>
	

	<br><br><br>
<br><br><br><br><br><br><br><br><br>
</article>

		

<?php  $this->registerJsFile(Yii::$app->request->baseUrl.'/js/list_comment.js');
	$script =<<< JS
$(document).pjax('retrieveComment' + $comment_id, '#childCommentData-' + $comment_id, { fragment: '#childCommentData-' + $comment_id });

$('#childCommentData-' + $comment_id ).on('pjax:error', function (event) {
						    alert('Failed to load the page');
						    event.preventDefault();
						});
JS;
	$this->registerJs($script);
?>