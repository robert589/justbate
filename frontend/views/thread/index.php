<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use kartik\tabs\TabsX;
use kartik\dialog\Dialog;
use yii\widgets\ActiveForm;

/** @var $thread \common\entity\ThreadEntity */
/** @var $comment_model \frontend\models\CommentForm */
/** @var $submit_vote_form \frontend\models\SubmitThreadVoteForm */

//variable used in this page
$this->title =  $thread->getTitle();
$guest  = $thread->isGuest();
$thread_belongs_to_current_user = $thread->belongToCurrentUser();
$comment_providers = $thread->getCommentList();
$thread_issues= $thread->getThreadIssues();
$content_comment = array();
$choices_in_thread = $thread->getChoices();
$thread_id = $thread->getThreadId();
$first = 1;

foreach($comment_providers as $thread_choice_item => $comment_provider){
	$content_comment_item['label'] = $thread_choice_item;
	$content_comment_item['content'] =  ListView::widget([
		'dataProvider' => $comment_provider,
		'summary' => false,
		'itemOptions' => ['class' => 'item'],
		'layout' => "{summary}\n{items}\n{pager}",
		'itemView' => function ($thread_comment, $key, $index, $widget) {
			$child_comment_form = new \frontend\models\ChildCommentForm();
			$creator = (new \common\creator\CreatorFactory())->getCreator(
												\common\creator\CreatorFactory::THREAD_COMMENT_CREATOR,
												$thread_comment);
			$thread_comment = $creator->get([\common\creator\ThreadCommentCreator::NEED_COMMENT_VOTE]);

			return $this->render('_listview_comment',['thread_comment' => $thread_comment,
						                  			'child_comment_form' => $child_comment_form,
									]);
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

//start of html
?>

<?= Dialog::widget(); ?>

<?php if(Yii::$app->user->isGuest){ ?>

<label> Please login before doing any action. Otherwise, it will not work </label>

<?= Html::button('Login', ['class' => 'btn btn-default', 'id' => 'login-modal-button']) ?>

<?php } ?>

<div class="col-xs-12 col-md-8" id="thread-main-body" style="background: white">

	<div class="col-xs-12" style="padding: 0;" id="left-part-of-thread">

		<div id="thread-details" class="col-xs-12">
			<?= $this->render('_title_description_vote',
				['thread' => $thread ,
				 'submit_vote_form' => $submit_vote_form])
			?>
		</div>

		<div id="thread-issue-wrapper">
			<?= $this->render('_thread_issues', ['thread_issues' => $thread_issues]) ?>
		</div>

		<div class="col-xs-12" id="action-button">
			<?= Html::button('Comment', [ 'id' => 'display_hide_comment_input_box', 'class' => 'btn']) ?>

			<?php if($thread_belongs_to_current_user) { ?>

			<?= Html::button('Delete', ['id' => 'delete_thread', 'class' => 'btn', 'style' => 'background: #d9534f;']) ?>

			<?= Html::button('Edit', ['id' => 'edit_thread', 'class' => 'btn','data-guest' => $guest]) ?>

			<?php } ?>

		</div>
	</div>


	<div  id="comment_section" class="section col-xs-12" style="display:none">

		<div class="row" >
			<?= $this->render('_comment_input_box', ['comment_model' => $comment_model,
													'thread' => $thread,
													'comment_input_retrieved' => true,
													]) ?>
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
	<?= Html::hiddenInput('thread_id', $thread_id) ?>
<?php ActiveForm::end() ?>
