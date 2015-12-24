<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin();?>
	
	<?= $form->field($model, 'first_name') ?>
	<?= $form->field($model, 'last_name') ?>
	<?= $form->field($model, 'email') ?>
	<?= $form->field($model, 'birthday') ?>

	<div class="form-group">
		<?= Html::submitButton('Submit',['class'=>'btn-btn-primary']) ?>
		<?= Html::resetButton('Reset',['class'=>'btn-btn-primary']) ?>
	</div>

<?php ActiveForm::end(); ?>