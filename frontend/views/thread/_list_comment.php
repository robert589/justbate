<?php

use kartik\rating\StarRating;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ListView;
use yii\bootstrap\Modal;
use frontend\models\EditCommentForm;
use frontend\models\Comment;

	//Store this variable for javascript
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
	<?php if(!empty($model)){  
		$thread_id = $model['thread_id'];
	?>


		<!--First TOP -->
		<div class="row">
			<!--The name of the person that make the comments -->
			<div class="col-md-6">
				<?= Html::a($model['first_name'] . ' ' . $model['last_name'], Yii::$app->homeUrl . "../../profile/index?id=" . $model['user_id'] )?>
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
			
		<?php } ?>

		<?php 
		Pjax::begin([
			'id' => 'submitComment-' . $comment_id,
			'timeout' => false,
			'enablePushState' => false,
			'clientOptions' => [
				'container' => '#submitComment-' . $comment_id,
			]
		]); 
		?>




		<div class="row">
			<?= Html::beginForm('../thread/index?id=' . $thread_id, 'post', ['id'=>"childForm-$comment_id" ,'data-pjax' => '', 'class' => 'form-inline']); ?>

				<?= Html::hiddenInput('commentRetrieved', 0, ['id' => 'commentRetrieved-'.$comment_id]) ?>


				<?= Html::hiddenInput('parent_id', $comment_id) ?>
				<!--Comment box form here-->
				<?= Html::textarea('childComment', null, ['class'=> 'form-control', 'id' => "child-comment-box-$comment_id", 
														'placeholder' => 'add comment box...', 'rows' => 1, 'style' => 'min-width:100%;display:none' ]) ?>

			<?= Html::endForm() ?>
		</div>

			<br>
			
			<?php 
	
				Pjax::begin([
				'id' => 'childCommentData-'.$comment_id,
		    	'timeout' => false,
		    	'enablePushState' => false,
		    	'clientOptions'=>[
				    	'container' => '#childCommentData-' . $comment_id,
				    	'linkSelector'=>'#retrieveComment'.$comment_id
						]
				]);
	
			?>
			
			<div  class="row">

				<div align="right">
						
						<?= Html::button('Delete', ['id' => "deleteComment$comment_id", 'class' => 'btn btn-default', 'style' => 'display:none']) ?>

						<?= Html::button('Edit', ['id' => "editComment$comment_id", 'class' => 'btn btn-default', 'style' => 'display:none']) ?>					

						<?= Html::button('Reply', ['id' => "showChildCommentBox$comment_id", 'class' => 'btn btn-default']) ?>

						<?= Html::a('Retrieve Comment', ["../../thread/index?id=" . $thread_id . "&comment_id=" . $comment_id], 
														['data-pjax' => '#childCommentData-'.$comment_id, 'class' => 'btn btn-default'
											,'id' => 'retrieveComment' . $comment_id]) ?>
				</div>
				<div  class="col-md-12" style="border-left: solid #e0e0d1;">

					<?php if(isset($retrieveChildData)){ ?>
						<?= ListView::widget([

								'dataProvider' => $retrieveChildData,
								'options' => [
									'tag' => 'div',
									'class' => 'list-wrapper',
										'id' => 'list-wrapper',
								],
				    				'layout' => "\n{items}\n{pager}",

								'itemView' => function ($model, $key, $index, $widget) {
									return $this->render('_list_child_comment',['model' => $model]);
								}, 
								'pager' => [
					       	 		'firstPageLabel' => 'first',
					        		'lastPageLabel' => 'last',
					        		'nextPageLabel' => 'next',
					        		'prevPageLabel' => 'previous',
					        		'maxButtonCount' => 3,
									],
							]) ?>

					<?php } ?>
					

				</div>
			</div>
			<?php Pjax::end();?>
		<br>
		<hr>

		<?php Pjax::end();?>

	</div>
	

	<br><br><br>
<br><br><br><br><br><br><br><br><br>


</article>
		

<?php  
$script =<<< JS

//Initially both delete and edit will be empty
if($belongs){
	$("#deleteComment$comment_id").show();
	$("#editComment$comment_id").show();
}

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
.on('keydown', '#child-comment-box-$comment_id', function(event){
    if (event.keyCode == 13) {
    	if($guest){
			beginLoginModal();
		}
        $("#childForm-$comment_id").submit();
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
.on('pjax:error', '#childCommentData-' + $comment_id, function (event) {
    alert('Failed to load the page');
	//					    $.pjax.reload({container:'#childCommentData-' + $comment_id});

    event.preventDefault();
})
.on('pjax:success', '#childCommentData-' + $comment_id, function(event, data, status, xhr, options) {
  // run "custom_success" method passed to PJAX if it exists
  $("#commentRetrieved-$comment_id").val(1);
});



$(document).pjax('retrieveComment' + $comment_id, '#childCommentData-' + $comment_id, { fragment: '#childCommentData-' + $comment_id });
JS;
$this->registerJs($script);
?>