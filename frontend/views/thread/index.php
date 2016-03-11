<?php
	use yii\widgets\ListView;
	use yii\helpers\Html;
	use kartik\tabs\TabsX;
	use kartik\dialog\Dialog;
	use yii\widgets\ActiveForm;

	/** @var $model array */
	/** @var $commentModel \frontend\models\CommentForm */
	/** @var $comment_providers \yii\data\ArrayDataProvider */
	/** @var $thread_choices array */
	/** @var $submitVoteModel \frontend\models\SubmitThreadVoteForm */
	$this->title =  $model['title'];

	//Store this variable for javascript
	if(!empty(\Yii::$app->user->isGuest)){
		$guest = "1";
	}
	else{
		$guest = "0";
	}


	$content_comment = array();

	$first = 1;
	foreach($comment_providers as $thread_choice_item => $comment_provider){
		$content_comment_item['label'] = $thread_choice_item;
		$content_comment_item['content'] =  ListView::widget([
										'dataProvider' => $comment_provider,
										'summary' => false,
										'itemOptions' => ['class' => 'item'],
										'layout' => "{summary}\n{items}\n{pager}",
										'itemView' => function ($model, $key, $index, $widget) {
											$childCommentForm = new \frontend\models\ChildCommentForm();

											if (Yii::$app->user->isGuest) {
												$belongs = 0;
											}
											else {
												if(Yii::$app->user->getId()== $model['user_id']){
													$belongs = 1;
												} else {
													$belongs = 0;
												}
											}

											$comment_vote_comment = \common\models\CommentVote::getCommentVotesOfComment($model['comment_id'], Yii::$app->getUser()->getId());
											return $this->render('_listview_comment',['model' => $model,
												'belongs' => $belongs,
												'child_comment_form' => $childCommentForm,
												'total_like' => $comment_vote_comment['total_like'],
												'total_dislike' => $comment_vote_comment['total_dislike'],
												'vote' => $comment_vote_comment['vote']]);
										}
									]);
		if($first == 1){
			$content_comment_item['active'] = true;
			$first = 0;
		}
		else{
			$content_comment_item['active'] = false;
		}

		$content_comment[] = $content_comment_item;
	}
?>

<?= Dialog::widget(); ?>

<div class="col-xs-8 col-md-offset-1" style="background-color: white">
	<div class="col-xs-12" id="thread-title">
		<?= $model['title'] ?>
	</div>
	<div class="col-xs-12" style="padding: 0;" id="left-part-of-thread">
		<div id="thread-details" class="col-xs-12">
			<?= $this->render('_title_description_vote', ['title' => $model['title'],
														'description' => $model['description'],
														'thread_choices' => $thread_choices,
														'thread_id' => $model['thread_id'],
														'user_choice' => $model['user_choice'],
														'submitVoteModel' => $submitVoteModel])
														?>
		</div>

		<div class="col-xs-12" id="action-button" style="padding: 0;">
			<?php if($model['user_id'] == \Yii::$app->user->id) { ?>
				<script type="text/javascript">
					$("#edit_thread").css("display","none");
					$("#delete_thread").css("display","none");
				</script>
			<?php } ?>
			<div id="action-button-thing"><?= Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['id' => 'edit_thread', 'class' => 'btn']) ?></div>
			<div id="action-button-thing"><?= Html::button('<span class="glyphicon glyphicon-trash"></span>', ['id' => 'delete_thread', 'class' => 'btn', 'style' => 'background: #d9534f;']) ?></div>
			<div id="action-button-thing"><?= Html::button('<span class="glyphicon glyphicon-comment"></span>', [ 'id' => 'display_hide_comment', 'class' => 'btn']) ?></div>
			<div id="action-button-thing"><?= Html::button('<span class="fa fa-facebook"></span>', ['id' => 'share-on-facebook', 'class' => 'btn']) ?></div>
		</div>
	</div>

	<div class="row" id="ask_to_login" style="display: none;">
		You need to login to perform this action,  click <?= Html::a('Login','', ['id' => 'login_link']) ?>
	</div>



	<hr>

	<div  id="comment_section" style="display:none">
		<div class="row" >
			<?= $this->render('_comment_input_box', ['commentModel' => $commentModel,
													'thread_choices' => $thread_choices,
													'thread_id' => $model['thread_id']]) ?>
			<br><br>
		</div>
		<hr>
	</div>

	<div class="row">
		<?= // Ajax Tabs Above
			TabsX::widget([
				'items'=>$content_comment,
				'position'=>TabsX::POS_ABOVE,
				'encodeLabels'=>false
			])
			?>
	</div>


</div>

<?php $form = ActiveForm::begin(['action' => ['delete-thread'], 'method' => 'post', 'id' => 'delete_thread_form']) ?>
	<?= Html::hiddenInput('thread_id', $model['thread_id']) ?>
<?php ActiveForm::end() ?>

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
	}).on('click', '#display_hide_comment', function(){
		if($guest){
			beginLoginModal();
			return false;
			$("#ask_to_login").show();
		}
		else{
			if($("#display_hide_comment").text() == "Comment"){
				$("#comment_section").show();
				$("#display_hide_comment").text("Hide");
			}
			else{
				$("#comment_section").hide();
				$("#display_hide_comment").text("Comment");
			}
		}

	});

JS;
$this->registerJs($script);

?>
