<?php
use kartik\rating\StarRating;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<article>
	<div class="box col-md-12">
		<div class="row" style="margin: 0;">
			<hr>

			<div class="col-xs-12" style="font-size: 20px; line-height: 40px !important;">
				<?= Html::a($model['title'], Url::to('../thread/index?id='. $model['thread_id']))?>
			</div>
			<div class="col-xs-12">
				<?= $model['description'] ?>
			</div>
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
		</div>
		</div>
</article>
