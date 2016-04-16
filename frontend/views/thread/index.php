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
	/** @var $thread_issues array all issues of the title */

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

<div class="col-xs-12 col-md-8" style="background-color: white">

	<div class="col-xs-12" style="padding: 0;" id="left-part-of-thread">

		<div style="margin: 5px;display: inline-block">
			<?= $this->render('_thread_issues', ['thread_issues' => $thread_issues]) ?>
		</div>

		<div id="thread-details" class="col-xs-12">
			<?= $this->render('_title_description_vote', ['title' => $model['title'],
														'description' => $model['description'],
														'thread_choices' => $thread_choices,
														'thread_id' => $model['thread_id'],
														'user_choice' => $model['user_choice'],
														'submitVoteModel' => $submitVoteModel])
														?>
		</div>

		<div class="col-xs-12" id="action-button">
			<?= Html::button('Comment', [ 'id' => 'display_hide_comment_input_box', 'class' => 'btn']) ?>
			<!-- Not working yet
			 Html::button('Share on facebook', ['id' => 'share_on_facebook', 'class' => 'btn'])
			-->
			<?php if($model['user_id'] == \Yii::$app->user->id) { ?>
				<?= Html::button('Delete', ['id' => 'delete_thread', 'class' => 'btn', 'style' => 'background: #d9534f;']) ?>
				<?= Html::button('Edit', ['id' => 'edit_thread', 'class' => 'btn','data-guest' => $guest]) ?>
			<?php } ?>
		</div>
	</div>

	<!-- Not working yet
		<div class="col-xs-12" id="ask_to_login" style="display: none;">
			You need to login to perform this action,  click <?= Html::a('Login','', ['id' => 'login_link']) ?>
		</div>
	-->

	<div  id="comment_section" class="section col-xs-12" style="display:none">
		<div class="row" >
			<?= $this->render('_comment_input_box', ['commentModel' => $commentModel,
													'thread_choices' => $thread_choices,
													'thread_id' => $model['thread_id']]) ?>
		</div>
	</div>


	<div class="col-xs-12 section">
		<div id="comment-tab">
			<?= // Ajax Tabs Above
				TabsX::widget([
					'id' => 'comment-tab',
					'items'=>$content_comment,
					'position'=>TabsX::POS_ABOVE,
					'encodeLabels'=>false,
					'enableStickyTabs' => true
				])
			?>
		</div>
	</div>


</div>

<?php $form = ActiveForm::begin(['action' => ['delete-thread'], 'method' => 'post', 'id' => 'delete_thread_form']) ?>
	<?= Html::hiddenInput('thread_id', $model['thread_id']) ?>
<?php ActiveForm::end() ?>
