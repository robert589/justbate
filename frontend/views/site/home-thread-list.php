<?php
use kartik\rating\StarRating;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\HtmlPurifier;
use common\models\User;
use common\components\Constant;
/** @var $thread \frontend\vo\ThreadVo */
/** @var $thread_issues array */

/**
 * Used variable
 */
$link_to_thread = $thread->getThreadLink();
$thread_title = $thread->getTitle();
$thread_description = $thread->getDescription();
$thread_id = $thread->getThreadId();
$thread_issues = $thread->getThreadIssues();
$comment_request_url = $thread->getCommentRequestUrl();
$has_chosen_comment = $thread->hasChosenComment();
?>

<article data-service="<?= $thread_id ?>" class="list-thread">
	<div class="row" id="thread-issue">
		<?= $this->render('../thread/_thread_issues', ['thread' => $thread]) ?>
	</div>
	<div class="col-xs-12 thread-view">
		<div class="col-xs-12 thread-link" align="center">
			<?= Html::a(Html::encode($thread_title), $link_to_thread)?>
		</div>
		<div class="col-xs-12" style="margin-bottom: 10px;" align="center">
			<?= HtmlPurifier::process($thread_description, Constant::DefaultPurifierConfig()) ?>
		</div>
		<div align="center">
			<?= $this->render('../thread/_thread_vote',
							 ['thread' => $thread,
							  'submit_thread_vote_form' => new \frontend\models\SubmitThreadVoteForm()])?>
		</div>

		<div class="user-comment-reaction col-xs-12">
			<div class="home-comment-tab">
				<?= $this->render('home-thread-list-bottom', ['thread' => $thread]) ?>
			</div>
			<hr>

			<?php if($has_chosen_comment){
				/** Used Variable */
				$chosen_comment = $thread->getChosenComment();
				$commentator_user_profile_link = $chosen_comment->getUserProfileLink();
				$commentator_user_profile_pic_link = $chosen_comment->getCommentCreatorPhotoLink();
				$commentator_choice = $chosen_comment->getCurrentUserVote();
				$commentator_full_name = $chosen_comment->getFullName();
				$comment  = $chosen_comment->getComment();
			?>

			<hr>
			<div class="col-xs-12">
				<?= $this->render('../comment/thread-comment', ['thread_comment' => $chosen_comment]) ?>
			</div>
			<div class="col-xs-12">
				<hr style="margin-bottom: 0">
				<?= Html::a('View other comments <span class="glyphicon glyphicon-arrow-right"></span>', $link_to_thread, ['target' => '_blank']) ?>
			</div>
		<?php
		}
		?>
		</div>
	</div>
</article>
