<?php
use kartik\rating\StarRating;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\HtmlPurifier;
use common\models\User;
/** @var $thread \common\entity\ThreadEntity */
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

<article data-service="<?= $thread_id ?>">
	<div class="col-xs-12" id="thread-issue">
		<?= $this->render('_thread_issues', ['thread_issues' => $thread_issues]) ?>
	</div>
	<br>
	<div class="col-xs-12 thread-view">
		<div class="col-xs-12 thread-link">
			<div class="col-xs-10 thread-title-list"><?= Html::a(Html::encode($thread_title), $link_to_thread)?></div>
			<div class="col-xs-2" style="font-size: 12pt; text-align: right;">
				<div class="fb-share-button" data-href="<?= $link_to_thread ?>" data-layout="button_count"></div>
			</div>
		</div>

		<br>

		<div>
		<!-- Voting -->
			<?= $this->render('_list_thread_thread_vote',
							 ['thread' => $thread,
							  'submit_thread_vote_form' => new \frontend\models\SubmitThreadVoteForm()])
			?>
			<br><br>
		</div>

		<div class="user-comment-reaction col-xs-12">
		<?php
		if($has_chosen_comment){
			/**
			 * Used Variable
			 */
			$chosen_comment = $thread->getChosenComment();
			$commentator_user_profile_link = $chosen_comment->getCommentatorUserProfileLink();
			$commentator_user_profile_pic_link = $chosen_comment->getCommentatorPhotoLink();
			$commentator_choice = $chosen_comment->getCommentatorChoice();
			$commentator_full_name = $chosen_comment->getFullName();
			$comment  = $chosen_comment->getComment();
		?>

			<div class="col-xs-1"  style="padding-left: 0; padding-right: 0;">
				<img src="<?= $commentator_user_profile_pic_link ?>" class="img img-circle" height="50px" width="50px" />
			</div>
			<div class="col-xs-offset-1 col-xs-11" style="margin-top: -68px; margin-left: 55px;">
				<div class="name-link inline">
					<?= $commentator_full_name ?> chose <?= $commentator_choice ?>
				</div>
			</div>

			<div class="col-xs-offset-1 col-xs-11" style="padding-left: 0; margin-left: 70px; margin-top: -40px;" >
				<?= HtmlPurifier::process($comment) ?>
			</div>

			<div class="col-xs-12 home-comment-tab" style="margin-left:0; padding-left: 0">
				<br>

				<?= $this->render('../thread/_listview_comment_bottom', [
					'thread_comment' => $chosen_comment , 'is_thread_comment' => true]) ?>
			</div>

		<?php
		}
		else{
		?>

			<div class="col-xs-11" style="margin-bottom: 10px;">
				<?= HtmlPurifier::process($thread_description) ?>
			</div>

			<div class="col-xs-12 home-comment-tab">
				<?= $this->render('_list_thread_bottom', [
					'thread' => $thread]) ?>
			</div>


		<?php
		}
		?>

		</div>
	</div>
</article>
