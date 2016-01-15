<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ListView;

	$comment_id = $model['comment_id'];

	//if the person is not guests
	if(!empty(\Yii::$app->user->isGuest)){
		$guest = "1";
		$belongs = "0";
	}
	else{
		if(!empty(\Yii::$app->user->getId())){
			$user_id = \Yii::$app->user->getId();
			//the belongs variable will be used in javascript
			//to set whether edit and delete button will be shown
			if($user_id == $model['user_id']){
				$belongs = "1";
			} 
			else{
				$belongs = "0";
			}
		}

		$guest = "0";
	}
?>

<br>
<article>
	<div class="box col-md-12">
		<div class="row">
			<div class="col-md-6">
				<?= Html::a($model['first_name'] . ' ' . $model['last_name'], "#" )?>
			</div>

			<?php 
				$vote = null;
				Pjax::begin([
    				'id' => 'comment-child-main-' . $comment_id,
                    'timeout' => false,

			        'clientOptions'=>[
			            'container'=>'w1child' . $comment_id,
					]
				]);
            ?>

				<!-- The form only be used as refresh page -->
				<?= Html::beginForm(["../../thread/index?id=" . $model['thread_id']  ], 'post', ['id' => 'submitvote-form-child-' . $comment_id, 'data-pjax' => 'w1child' . $comment_id, 'class' => 'form-inline']); ?>

					<?= Html::hiddenInput("child-vote", $model['vote'], ['id' => "vote_result_child_$comment_id"])?>

					<?= Html::hiddenInput("comment_id", $comment_id, ['id' => 'comment_id']) ?>

					<?php 
						$voteUp = ($model['vote'] == 1) ? 'disabled' : false;
						$voteDown = ($model['vote'] == -1) ? 'disabled' : false;
					?>
					<div class="col-md-6">
						<div class="col-md-3">
							<button type="button" <?php if($voteUp) echo 'disabled' ?> class="btn btn-default" style="border:0px solid transparent" id="btnVoteUp-child-<?=$comment_id?>">
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
							<button  type="button" <?php if($voteDown) echo 'disabled' ?> class="btn btn-default" style="border:0px solid transparent" id="btnVoteDown-child-<?=$comment_id?>">
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


<?php  
$script =<<< JS
function beginLoginModal(){
		$("#loginModal").modal("show")
			.find('#loginModal')
			.load($(this).attr("value"));
}
// Button voteup child when clicked
$( document ).on( 'click', "#btnVoteUp-child-$comment_id", function () {
    // Do click stuff here
	$("#vote_result_child_$comment_id").val(1);
	if($guest){
		beginLoginModal();
		return false;
	}
	$("#submitvote-form-child-$comment_id").submit();
})
//Button votedown when clicked
.on( 'click', "#btnVoteDown-child-$comment_id", function () {
    // Do click stuff here
	$("#vote_result_child_$comment_id").val(-1);
	if($guest){
		beginLoginModal();
		return false;
	}
	$("#submitvote-form-child-$comment_id"	).submit();
})



JS;
$this->registerJs($script);
?>
