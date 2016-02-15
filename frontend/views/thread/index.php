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

<!-- Login Modal-->
<?php
	Modal::begin([
			'header' => '<h4> Login </h4>',
			'id' => 'loginModal',
			'size' => 'modal-lg'
		]);

	$redirectFrom = \Yii::$app->homeUrl . '../../thread/index?id=' . $model['thread_id'];
	$loginModel = new LoginForm();
	echo $this->render('../site/login', ['model' => $loginModel,  'redirectFrom' => $redirectFrom]);
	Modal::end();
?>



<div class="container">
	<div class="col-md-10" style="line-height: 2em !important;">
		<div class="row">
			<div class="col-md-12" style=""><?php echo $this->render('_submit_rate_pjax',['thread_id' => $model['thread_id'], 'avg_rating' => $model['avg_rating'], 'total_raters' => $model['total_raters']] );?></div>
			<div class="col-md-12"><h2><?= $model['title'] ?> </h2></div>
		</div>

		<hr>

		<div class="row" style="border:1px solid ">
			<div class="col-md-5"><?= $this->render('_submit_vote_pjax', ['model' => $model, 'thread_choice' => $thread_choice, 'submitVoteModel' => $submitVoteModel]) ?></div>
			<div class="col-md-7"><?= $this->render('_comment_input_box.php', [ 'thread_id' => $model['thread_id'], 'commentModel' => $commentModel, 'thread_choice' => $thread_choice]) ?></div>
		</div>

		<hr>

		<!-- Content -->
		<div class="row" style="margin:1px">
			<?= $model['description']?>
		</div>

		<br>

		<!-- Comment Part-->
		<div class="row">
			<?php foreach($comment_providers as $thread_choice => $comment_provider){ ?>

				<div class="col-md-6">
					<div align="center">
						<h3><?= $thread_choice?></h3>
					</div>
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

					]) ?>
				</div>

			<?php } ?>
		</div>
	</div>
</div>


<?php

//Inline script, not really good
$script =<<< JS
	function beginLoginModal(){
		$("#loginModal").modal("show")
			.find('#loginModal')
			.load($(this).attr("value"));
	}

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
