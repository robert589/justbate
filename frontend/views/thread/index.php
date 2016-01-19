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

	$this->title = "Thread | " . $model['title'];

	//Store this variable for javascript
	if(!empty(\Yii::$app->user->isGuest)){
		$guest = "1";
		
	}
	else{
		$guest = "0";
	}

	//check whether the comment belongs to the user


		$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.js');
	//$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.elastic.js');
?>

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
		<div class="col-md-8">	
			<h2><?= $model['title'] ?> </h2>
		</div>

		<?php Pjax::begin([
				'id' => 'submitRating',
		    	'timeout' => false,
		    	'enablePushState' => false,
		    	'clientOptions'=>[
				    	'container' => '#submitRating',
						]
				]);?>
		<!--Rating Part-->
		<div class="col-md-4">

			<!--Rating form part-->
			<?= Html::beginForm('../thread/index?id=' . $model['thread_id'], 'post', ['id'=>"ratingForm" ,'data-pjax' => '', 'class' => 'form-inline']); ?>

						<?= Html::hiddenInput('userThreadRate', null, ['id' => 'userThreadRate']) ?>

			<?= Html::endForm() ?>

			<?= StarRating::widget([
	    			'name' => 'rating_2',
	    			'id' => 'thread_rating',
	    			'value' => $model['avg_rating'],
	    			'readonly' => false,
	    			'pluginOptions' => [
	    				'showCaption' => true,
	        			'min' => 0,
	        			'max' => 5,
	        			'step' => 1,
	       	 			'size' => 'xs',
	       			],
	       			'pluginEvents' => [
	       			] 			
			])?>



			<div align="center">
				<label> <?= $model['total_voters'] ?> Voters </label>
			</div>
			


		</div>

		<?php Pjax::end();?>

	</div>
	<div class="row" style="margin:1px">
		<?= $model['content']?>
	</div>



	<br><br>


	<!--Comment Part-->

	<?php $form =ActiveForm::begin(['id' => 'comment-form']) ?>


	<div class="row">
		<div class="col-md-offset-2	col-md-5">
	   		<?= $form->field($commentModel, 'comment')->textArea(['id' => 'comment-box', 'placeholder' => 'add comment box...', 'rows' => 2 ]) ?>
			</div>
		<div class="col-md-4">
			<label> Choose your side </label>
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