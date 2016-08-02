<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use kartik\tabs\TabsX;
use kartik\dialog\Dialog;
use yii\widgets\ActiveForm;

/** @var $thread \frontend\vo\ThreadVo */
/** @var $comment_model \frontend\models\CommentForm */
/** @var $submit_vote_form \frontend\models\SubmitThreadVoteForm */

//variable used in this page
$this->title =  $thread->getTitle();

$comment_providers = $thread->getThreadCommentList();
$content_comment = array();
$choices_in_thread = $thread->getChoices();
$thread_id = $thread->getThreadId();
$thread_belongs_to_current_user = $thread->belongToCurrentUser();
$guest = $thread->isGuest();
$current_user_anonymous = $thread->getCurrentUserAnonymous();
$first = 1;
foreach($comment_providers as $thread_choice_item => $comment_provider){
    $content_comment_item['label'] = Html::encode($thread_choice_item);
    $content_comment_item['content'] =  ListView::widget([
            'dataProvider' => $comment_provider,
            'summary' => false,
            'itemOptions' => ['class' => 'item'],
            'layout' => "{summary}\n{items}\n{pager}",
            'itemView' => function ($thread_comment, $key, $index, $widget) {
                    return $this->render('../comment/thread-comment'	,
                                        ['thread_comment' => $thread_comment,
                                         'child_comment_form' => new \frontend\models\ChildCommentForm()]);
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

<div class="col-xs-12 col-md-6" id="thread-main-body" style="background: white; padding-bottom: 30px;">
	<div class="col-xs-12" style="padding: 0;" id="left-part-of-thread">
		<div id="thread-details" class="col-xs-12">
			<?= $this->render('thread-section',
				['thread' => $thread ,
				 'edit_thread_form' => new \frontend\models\EditThreadForm(),
				 'submit_vote_form' => $submit_vote_form])
			?>
		</div>
		<!-- First tab part -->
		<div class="row" id="first-part">
			<div class="col-xs-12" style="margin-bottom:12px">
				<?=	
                                    $this->render('thread-vote', ['thread' => $thread,
                                        'submit_thread_vote_form' => new \frontend\models\SubmitThreadVoteForm()]);
				?>
			</div>
			<div class="col-xs-12">
				<div class="inline">
					<?= $this->render('retrieve-comment-button', ['thread' => $thread]) ?>
				</div>
				<div class="inline" style="margin-left: 5px">
					<?= \frontend\widgets\CommentInputAnonymous::widget(['anonymous' => $current_user_anonymous,
						'thread_id' => $thread_id ]) ?>
				</div>
				<?php if($thread_belongs_to_current_user) { ?>
					<div class="inline">
						<?= Html::button('Delete', ['id' => 'delete-thread', 'class' => 'btn btn-sm inline', 'style' => 'background: #d9534f;']) ?>
						<?= Html::button('Edit', ['id' => 'edit-thread', 'class' => 'btn btn-sm inline','data-guest' => $guest]) ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<div  id="comment_section" class="section col-xs-12">
		<?= $this->render('thread-comment-input-box', ['comment_model' => $comment_model,
                                                            'thread' => $thread]) ?>
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
