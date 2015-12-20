<?php
use kartik\rating\StarRating;

use yii\helpers\Html;

use yii\helpers\Url;

?>

<article>

	<hr>
	<div class="box col-md-12">


		<div class="row">
				<?= Html::a($model->name, Url::to('thread/index.php?id='. $model->thread_id))?>
		</div>
		<div class="row">
			<p> <?= $model->content ?> </p>	
		</div>
		
		<div class="row">

		<div class="col-md-4">
			<?= StarRating::widget([
    			'name' => 'rating_2',
    			'value' => 2.5,
    			'readonly' => true,
    			'pluginOptions' => [
    				'showCaption' => false,
        			'min' => 0,
        			'max' => 5,
        			'step' => 1,
       	 			'size' => 'xs',
       	 			'width' => '80%',
       	 			'height' => '80%'
				]])?>
		</div class="col-md-8" align="center center-vertical">
			<p align="right">Created by   <?= $model->user->first_name?>  <?=$model->user->last_name?> at <?= $model->date_created ?></p>


		</div>
		</div>
		

	<br><br><br>
<br><br><br><br><br><br><br><br><br>
</article>