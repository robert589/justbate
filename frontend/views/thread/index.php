<?php
	use yii\widgets\ActiveForm;
	use yii\helpers\Url;
	use yii\widgets\Pjax;
	use yii\widgets\ListView;
	use yii\bootstrap\Modal;
	use yii\helpers\Html;
	use kartik\tabs\TabsX;

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
											$comment_vote_comment = \common\models\CommentVote::getCommentVotesOfComment($model['comment_id'], Yii::$app->getUser()->getId());
											return $this->render('_listview_comment',['model' => $model, 'child_comment_form' => $childCommentForm,
												'total_like' => $comment_vote_comment['total_like'], 'total_dislike' => $comment_vote_comment['total_dislike'],
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

<div class="col-md-offset-2 col-md-10">
	<div class="col-md-8" align="center">
		<!-- Submit Rate Part-->
		<div class="row">
			<div style="float: left;" class="col-xs-12">
				<?=
				$this->render('_submit_rate_pjax',['thread_id' => $model['thread_id'],
					'avg_rating' => $model['avg_rating'],
					'total_raters' => $model['total_raters']] );
				?>
			</div> <!-- div.col-xs-12 -->
		</div> <!-- div.row -->

		<?= $this->render('_title_description_vote', ['title' => $model['title'],
													'description' => $model['description'],
													'thread_choices' => $thread_choices,
													'thread_id' => $model['thread_id'],
													'user_choice' => $model['user_choice'],
													'submitVoteModel' => $submitVoteModel]) ?>

		<div class="row" id="ask_to_login" style="display:none">
			You need to login to perform this action,  click <?= Html::a('Login','', ['id' => 'login_link']) ?>
		</div>

		<div class="row">
			<?php if($model['user_id'] == \Yii::$app->user->id) { ?>

			<?= Html::button('Edit', ['id' => 'edit_thread', 'class' => 'btn btn-default']) ?>

			<?php } ?>
			<?= Html::button('Comment', [ 'id' => 'display_hide_comment', 'class' => 'btn btn-default']) ?>
			<?= Html::button('Share on facebook', ['class' => 'btn btn-default']) ?>
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

		<div class="row" style="border-color: #ccccff; height: 250px">
			<?= // Ajax Tabs Above
				TabsX::widget([
					'items'=>$content_comment,
					'position'=>TabsX::POS_ABOVE,
					'encodeLabels'=>false
				])
			?>
		</div>


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

$this->registerJsFile(Yii::$app->request->baseUrl . '/frontend/web/js/thread-index.js');
?>
