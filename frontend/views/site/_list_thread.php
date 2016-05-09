<?php
use kartik\rating\StarRating;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\HtmlPurifier;
/** @var $model array */
/** @var $comment array */
?>

<article data-service="<?=$model['thread_id'] ?>">
	<div class="col-xs-12" id="thread-issue">
		<?= $this->render('_thread_issues', ['thread_issues' => $thread_issues]) ?>
	</div>
	<div class="col-xs-12 thread-view">
		<div class="col-xs-12 thread-link">
			<div class="col-xs-10 thread-title-list"><?= Html::a(Html::encode($model['title']), Yii::$app->request->baseUrl . '/thread/' . $model['thread_id'] . '/' . str_replace(' ' , '-', strtolower($model['title'])))?></div>
			<div class="col-xs-2" style="font-size: 12pt; text-align: right;"><span class="label label-primary"><span class="fa fa-facebook"></span></span></div>
			<hr />
		</div>
		<div class="col-xs-12">
			<?php if($comment != null || $comment != false){ ?>
				<div class="name-link inline"><?= $comment['first_name'] . ' '. $comment['last_name']  ?> </div> &nbsp; chooses <b><?= $comment['choice_text'] ?></b> and says <br>
				<br />
				<?= HtmlPurifier::process($comment['comment']) ?>
				<?php }else{ ?>
					<?= HtmlPurifier::process($model['description']) ?>
					<?php } ?><hr />
				</div>
				<div class="col-xs-12 home-comment-tab">
					<?= $this->render('_list_thread_bottom', [
						'user_choice_text' => $model['choice_text'],
						'thread_id' => $model['thread_id'],
						'thread_choice_text' => $thread_choice_text,
						'total_comments' => $model['total_comments']]) ?>
				</div>
		</div>
</article>
