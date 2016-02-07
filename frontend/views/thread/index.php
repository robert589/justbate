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

	$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.js');
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

	<hr>

	<?= $this->render('_submit_vote_pjax', ['thread_id' => $model['thread_id'], 'model' => $model]) ?>


	<hr>

	<!-- Content -->
	<div class="row" style="margin:1px">
		<?= $model['content']?>
	</div>



	<br><br>


	<!--Comment Input Part-->

	<?php $form =ActiveForm::begin(['id' => 'comment-form']) ?>


	<div class="row">
		<div class="col-md-offset-2	col-md-5">
	   		<?= $form->field($commentModel, 'comment')->textArea(['id' => 'comment-box', 'placeholder' => 'add comment box...', 'rows' => 2 ]) ?>
			</div>
		<div class="col-md-4">
			<label> Choose your Comment Side </label>
			<?= $form->field($commentModel, 'yes_or_no')->widget(Select2::classname(), [
				    'data' => [1 => 'Agree', 0 => 'Disagree'],
				    'options' => ['placeholder' => 'Select a state ...'],
				    'pluginOptions' => [
				        'allowClear' => true
				    ],
			])->label(false) ?>
		</div>

	</div>

	<?php ActiveForm::end(); ?>

	<br><br>

	<div class="row" style="margin:2px">
		<!-- Yes Comment -->

		<div class="col-md-6">
			<h1 align="center"> YES </h1>
			<?= ListView::widget([
				'dataProvider' => $yesCommentData,
				'options' => [
					'tag' => 'div',
					'class' => 'list-wrapper',
					'id' => 'list-wrapper',
				],
    				'layout' => "\n{items}\n{pager}",

				'itemView' => function ($model, $key, $index, $widget) {
					return $this->render('_list_comment',['model' => $model]);
				}, 
				'pager' => [
	       	 		'firstPageLabel' => 'first',
	        		'lastPageLabel' => 'last',
	        		'nextPageLabel' => 'next',
	        		'prevPageLabel' => 'previous',
	        		'maxButtonCount' => 3,
				],
			]) ?>

		</div>

		<!-- No Comment-->
		<div class="col-md-6">
			<h1 align="center"> NO </h1>
			<?= ListView::widget([
				'dataProvider' => $noCommentData,
				'options' => [
					'tag' => 'div',
					'class' => 'list-wrapper',
						'id' => 'list-wrapper',
				],
    				'layout' => "\n{items}\n{pager}",

				'itemView' => function ($model, $key, $index, $widget) {
					return $this->render('_list_comment',['model' => $model]);
				}, 
				'pager' => [
	       	 		'firstPageLabel' => 'first',
	        		'lastPageLabel' => 'last',
	        		'nextPageLabel' => 'next',
	        		'prevPageLabel' => 'previous',
	        		'maxButtonCount' => 3,
				],
			]) ?>
		
		</div>
	</div>




</div>


<?php

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