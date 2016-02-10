<?php

use kartik\rating\StarRating;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ListView;
use yii\bootstrap\Modal;
use frontend\models\EditCommentForm;
use common\models\Comment;
	if(Yii::$app->user->isGuest){
		$guest = 1;
		$belongs = 0;
	}
	else{
			$guest= 0;
		if(Yii::$app->user->getId()== $model['user_id']){
			$belongs = 1;

		}
		else{
			$belongs = 0;
		}
	}
	//Store this variable for javascript
	$comment_id = $model['comment_id'];

?>

<?php
	Modal::begin([
			'header' => '<h4> Edit Comment </h4>',
			'id' => "editModal-$comment_id",
			'size' => 'modal-lg'
		]);


		$redirectFrom = \Yii::$app->homeUrl . '../../thread/index?id=' . $model['thread_id'];
		$editCommentModel = new EditCommentForm();
		$editCommentModel->parent_id = $comment_id;
		$editCommentModel->comment = Comment::getComment($comment_id);
		echo $this->render('../thread/editModal', ['editCommentModel' => $editCommentModel]);

	Modal::end();
?>




<article>
	<div class="box col-md-12" >
		<!--First TOP -->
		<div class="row">
			<!--The name of the person that make the comments -->
			<div class="col-md-6">
				<?= Html::a($model['first_name'] . ' ' . $model['last_name'], Yii::$app->homeUrl . "../../profile/index?username=" . $model['username'] )?>
			</div>	

			<!--The vote name-->
			<?php 
				$vote = null;
				Pjax::begin([
							'id' => 'comment-main-' . $comment_id,
					       	'timeout' => 5000,
			
					        'clientOptions'=>[
					            'container'=>'w1' . $comment_id,
							]
			]); ?>


				<!-- The vote -->
				<!-- The form only be used as refresh page -->
				<?= Html::beginForm(["../../thread/index?id=" . $model['thread_id']  ], 'post', ['id' => 'submitvote-form-' . $comment_id, 'data-pjax' => 'w1' . $comment_id, 'class' => 'form-inline']); ?>

					<?= Html::hiddenInput("vote", $model['vote'], ['id' => "vote_result_$comment_id"])?>

					<?= Html::hiddenInput("comment_id", $comment_id, ['id' => 'comment_id']) ?>

					<?php $voteUp = ($model['vote'] == 1) ? 'disabled' : false;
						$voteDown = ($model['vote'] == -1) ? 'disabled' : false;
					?>

					<div class="col-md-6">
						<div class="col-md-3">
							<button id="btnVoteUp-<?=$comment_id?>" type="button" <?php if($voteUp) echo 'disabled' ?> class="btn btn-default" style="border:0px solid transparent" >
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
							<button  type="button" id="btnVoteDown-<?=$comment_id?>" <?php if($voteDown) echo 'disabled' ?> class="btn btn-default" style="border:0px solid transparent">
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

		<?= $this->render('_child_comment', ['guest' => $guest, 'belongs' => $belongs,
											'comment_id' => $model['comment_id'], 'thread_id' => $model['thread_id'],
											'user_id' => $model['user_id']]) ?>

	</div>
	

	<br><br><br>
<br><br><br><br><br><br><br><br><br>


</article>
		

<?php  
$script =<<< JS

//Begin edit modal
function beginEditModal$comment_id(){
	console.log($comment_id);
	$("#editModal-$comment_id").modal("show")
			.find('#editModal-$comment_id')
			.load($(this).attr("value"));
}

$( document ).on( 'click', "#showChildCommentBox$comment_id", function () {
    // Do click stuff here
   	
  	$("#child-comment-box-$comment_id").show();
})
.on('click', "#editComment$comment_id", function(){
	beginEditModal$comment_id();

	return false;
})
.on( 'click', "#btnVoteUp-$comment_id", function () {
    // Do click stuff here
	$("#vote_result_$comment_id").val(1);
	if($guest){
		beginLoginModal();
	}
	$("#submitvote-form-$comment_id"	).submit();
})
.on( 'click', "#btnVoteDown-$comment_id", function () {
    // Do click stuff here
	$("#vote_result_$comment_id").val(-1);
	if($guest){
		beginLoginModal();
	}
	$("#submitvote-form-$comment_id"	).submit();
})
.on( 'click', "#comment_id", function () {
    // Do click stuff here
  	$("#child-comment-box-$comment_id").show();
})
.on( 'click', "#hideButton$comment_id", function () {
    if($("#hideButton$comment_id").text() == 'Hide'){
  		$("#listviewChild$comment_id").hide();
  		$("#hideButton$comment_id").text('Show');
  	}else{
  		$("#listviewChild$comment_id").show();
  		$("#hideButton$comment_id").text('Hide');
  	}
})
.on('keydown', '#child-comment-box-$comment_id', function(event){
    if (event.keyCode == 13) {
    	if($guest){
			beginLoginModal();
		}
		else{
        	$("#childForm-$comment_id").submit();
    	}
        return false;
     }
})
.on('focus', '#child-comment-box-$comment_id', function(){
    if(this.value == "Write your comment here..."){
         this.value = "";
    }
})
.on('blur', '#child-comment-box-$comment_id', function(){
    if(this.value==""){
         this.value = "Write your comment here...";
    }
})
.on('pjax:error', '#submitComment-' + $comment_id, function (event) {
   // alert('Failed to load the page');
    event.preventDefault();
})
.on('pjax:error', '#childCommentData-' + $comment_id, function (event) {
   // alert('Failed to load the page');

    event.preventDefault();
})

.on('pjax:success', '#childCommentData-' + $comment_id, function(event, data, status, xhr, options) {
  // run "custom_success" method passed to PJAX if it exists
  $("#commentRetrieved-$comment_id").val(1);

  $("#commentShown-$comment_id").val(1);
});

$(document).pjax('retrieveComment' + $comment_id, '#childCommentData-' + $comment_id, { fragment: '#childCommentData-' + $comment_id });
JS;
$this->registerJs($script);
?>