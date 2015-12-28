<?php
	use kartik\rating\StarRating;
	use yii\widgets\ActiveForm;
	use yii\helpers\Url;
	use kartik\widgets\SwitchInput;
	use yii\widgets\Pjax;
	use yii\widgets\ListView;


	$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.js');
	//$this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.elastic.js');
?>


<div class="col-md-offset-2 col-md-9">
	<div class="row">
		<div class="col-md-8">
			<h2><?= $model['title'] ?> </h2>
		</div>
		<div class="col-md-4">
			<?= StarRating::widget([
	    			'name' => 'rating_2',
	    			'value' => $model['avg_rating'],
	    			'readonly' => false,
	    			'pluginOptions' => [
	    				'showCaption' => false,
	        			'min' => 0,
	        			'max' => 5,
	        			'step' => 1,
	       	 			'size' => 'xs',
	       	 			
					]])?>
		</div>


	</div>
	<div class="row" style="margin:1px">
		<?= $model['content']?>
	</div>



	<br><br>

	<?php Pjax::begin(); ?>


		<?php $form =ActiveForm::begin(['id' => 'comment-form']) ?>


		<div class="row">
			<div class="col-md-offset-2	col-md-5">
		   		<?= $form->field($commentModel, 'comment')->textArea(['id' => 'comment-box', 'placeholder' => 'add comment box...', 'rows' => 2 ]) ?>

			</div>
			<div class="col-md-4">
				<?= $form->field($commentModel, 'yes_or_no')->widget(SwitchInput::classname(), ['tristate' => true, 'pluginOptions' => ['size' => 'md']])->label("Side: ") ?>
			</div>

		</div>

		<?php ActiveForm::end(); ?>

		<br><br>

		<div class="row" style="margin:2px">
			<div class="col-md-6">
				<h1 align="center"> YES </h1>
			</div>
			<div class="col-md-6">
				<h1 align="center"> NO </h1>
			</div>
		</div>


		<div class="row">
			<div class="col-md-6">
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

	<?php Pjax::end(); ?>

</div>


<?php
	$this->registerJsFile(Yii::$app->request->baseUrl.'/js/profile-index.js');

?>