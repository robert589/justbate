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



<div class="col-md-offset-2 col-md-9">
	<div class="row">
		<!-- Title of the thread -->
		<div class="col-md-8">	
			<h2><?= $model['title'] ?> </h2>
		</div>

		<?php echo $this->render('_submit_rate_pjax',['thread_id' => $model['thread_id'], 'avg_rating' => $model['avg_rating'], 'total_raters' => $model['total_raters']] );?>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h3><?= $model['topic_description'] ?></h3>

		</div>
	</div>
	<hr>

	<?= $this->render('_submit_vote_pjax', ['model' => $model, 'thread_choice' => $thread_choice, 'submitVoteModel' => $submitVoteModel]) ?>

	<hr>

	<!-- Content -->
	<div class="row" style="margin:1px">
		<?= $model['user_opinion']?>
	</div>

	<br>

	<div class="row">
		<?php foreach($comment_providers as $thread_choice => $comment_provider){ ?>

			<div class="col-md-6">
				<label><?= $thread_choice?></label>
				<?= ListView::widget([
					'dataProvider' => $comment_provider,
					'pager' => ['class' => \kop\y2sp\ScrollPager::className()],
					'summary' => false,
					'itemOptions' => ['class' => 'item'],
					'layout' => "{summary}\n{items}\n{pager}",
					'itemView' => function ($model, $key, $index, $widget) {
						return $this->render('_list_comment',['model' => $model]);
					}

				]) ?>
			</div>

		<?php } ?>
	</div>



	<br><br>
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