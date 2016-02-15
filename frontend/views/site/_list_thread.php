<?php
use kartik\rating\StarRating;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<article>
	<div id="main-post" class="col-md-offset-3 col-xs-12 col-md-6"><hr />
		<div class="col-xs-12" style="font-size: 2em; line-height: 40px !important;"><?= Html::a($model['title'], Url::to('../thread/index?id='. $model['thread_id']))?></div>
		<div class="col-xs-12 col-md-5" style="margin: 0;">
			<?= StarRating::widget([
				'name' => 'rating_2',
				'value' => $model['avg_rating'],
				'readonly' => true,
				'pluginOptions' => [
					'showCaption' => false,
					'min' => 0,
					'max' => 5,
					'step' => 1,
					'size' => 'xs',
					]])
					?>
				</div>
				<div class="col-xs-12 col-md-7" style="margin: 0;">
					<p style="font-size:10pt; float: right;"><span class="glyphicon glyphicon-user"></span> <?= $model['first_name']?>  <?=$model['last_name']?> <span style="margin-left: 16px;" id="post-created"><span class="glyphicon glyphicon-time"></span> <?= $model['date_created'] ?></span></p>
				</div>
			</div>
		</article>
