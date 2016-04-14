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

<article>
	<div class="col-xs-12 thread-view">

		<div style="margin-bottom:3px">
			<?= $this->render('_thread_issues', ['thread_issues' => $thread_issues]) ?>
		</div>

		<div class="col-xs-12 thread-link">
			<?= Html::a(Html::encode($model['title']), Yii::$app->request->baseUrl . '/thread/' . $model['thread_id'])?>
		</div>
		<div class="col-xs-12">
			<hr>

			<?php if($comment != null || $comment != false){ ?>

					<div class="name-link inline"><?= $comment['first_name'] . ' '. $comment['last_name']  ?> </div> &nbsp; chooses <b><?= $comment['choice_text'] ?></b> and says <br>
					<br />
					<?= HtmlPurifier::process($comment['comment']) ?>

			<?php }else{ ?>
				<?= HtmlPurifier::process($model['description']) ?>
			<?php } ?>

			<hr>

		</div>
		<div class="col-xs-12 home-comment-tab">
			<?= $this->render('_list_thread_comment_part', ['thread_id' => $model['thread_id'],
															'total_comments' => $model['total_comments']]) ?>
		</div>
	</div>
</article>
