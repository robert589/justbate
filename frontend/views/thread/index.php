<?php
	use kartik\rating\StarRating;

?>


<div class="col-md-offset-2 col-md-9">
	<div class="row">
		<div class="col-md-8">
			<h2><?= $model['title'] ?> </h2>
		</div>
		<div class="col-md-4">
			<?= StarRating::widget([
	    			'name' => 'rating_2',
	    			'value' => $model['avg_rating'],
	    			'readonly' => false,
	    			'pluginOptions' => [
	    				'showCaption' => false,
	        			'min' => 0,
	        			'max' => 5,
	        			'step' => 1,
	       	 			'size' => 'xs',
	       	 			
					]])?>
		</div>


	</div>
	<div class="row" style="margin:1px">
		<?= $model['content']?>
	</div>



	<br><br>

	<div class="row" style="margin:2px">
		<div class="col-md-6">
			<h1 align="center"> YES </h1>
		</div>
		<div class="col-md-6">
			<h1 align="center"> NO </h1>
		</div>
	</div>
	</div>
</div>