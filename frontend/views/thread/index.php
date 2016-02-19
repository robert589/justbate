<?php
	use kartik\rating\StarRating;
	use yii\widgets\ActiveForm;
	use yii\helpers\Url;
	use kartik\widgets\Select2;
	use yii\widgets\Pjax;
	use yii\widgets\ListView;
	use yii\bootstrap\Modal;
	use common\models\LoginForm;
	use yii\helpers\Html;
	use kartik\widgets\SwitchInput;
	use common\models\CommonVote;
	$this->title =  $model['title'];

	//Store this variable for javascript
	if(!empty(\Yii::$app->user->isGuest)){
		$guest = "1";
	}
	else{
		$guest = "0";
	}

?>

<div class="container">
	<div class="row">
		<div style="float: left;" class="col-xs-12"><?php echo $this->render('_submit_rate_pjax',['thread_id' => $model['thread_id'], 'avg_rating' => $model['avg_rating'], 'total_raters' => $model['total_raters']] );?></div>
	</div>
		<div class="row" style="text-align: center;">
			<div class="col-md-12"><h2><?= $model['title'] ?> </h2></div>
		</div>
		<div class="row">
			<div class="col-md-12" style="text-align: center;"><h3><?= $model['description'] ?></h3></div>
		</div>
		<hr>

		<div class="row" style="border:1px solid; padding-bottom: 15px;">
			<div class="col-xs-6" align="center" style="height: 143px;">
				<?= $this->render('_submit_vote_pjax', ['model' => $model, 'thread_choice' => $thread_choice, 'submitVoteModel' => $submitVoteModel]) ?>
			</div>
			<div class="col-xs-6">
				<?= $this->render('_comment_input_box.php', [ 'thread_id' => $model['thread_id'], 'commentModel' => $commentModel, 'thread_choice' => $thread_choice]) ?>
			</div>
		</div>

		<hr />

		<!-- Comment Part-->
		<div class="row">
			<?php foreach($comment_providers as $thread_choice => $comment_provider){ ?>
				<div class="col-xs-12 col-md-4">
					<h3 id="user-choice" style="text-align: center;"><?= $thread_choice?></h3>
					<?= ListView::widget([
						'dataProvider' => $comment_provider,
						'summary' => false,
						'itemOptions' => ['class' => 'item'],
						'layout' => "{summary}\n{items}\n{pager}",
							'itemView' => function ($model, $key, $index, $widget) {
							$childCommentForm = new \frontend\models\ChildCommentForm();
							$comment_vote_comment = \common\models\CommentVote::getCommentVotesOfComment($model['comment_id'], Yii::$app->getUser()->getId());
							return $this->render('_listview_comment',['model' => $model, 'child_comment_form' => $childCommentForm,
													'total_like' => $comment_vote_comment['total_like'], 'total_dislike' => $comment_vote_comment['total_dislike'],
													'vote' => $comment_vote_comment['vote']]);
						}
					]) ?><hr />
				</div>
			<?php } ?>
		</div>
	</div>


<?php

//Inline script, not really good
$script =<<< JS

	$(document).on('keydown', '#comment-box', function(event) {
	    if (event.keyCode == 13) {
	    	console.log( 'e' + $guest);
	      	if($guest){
	      		beginLoginModal();
	      		return false;
	      	}
	        $("#comment-form").submit()
	        return false;
	     }
	}).on('focus', '#comment-box', function(){
	    if(this.value == "Write your comment here..."){
	         this.value = "";
	    }

	}).on('blur', '#comment-box',function(){
	    if(this.value==""){
	         this.value = "Write your comment here...";
	    }
	}).on('rating.change', '#thread_rating', function(event, value, caption) {
		if($guest){

			beginLoginModal();
			return false;
		}
		$("#userThreadRate").val(value);

		$("#ratingForm").submit();
		return false;
	});

JS;
$this->registerJs($script);
?>
