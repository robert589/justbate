<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Dropdown;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

	<?= $form->field($thread, 'title') ?>
	<?= $form->field($thread, 'category')->dropDownList($items, ['Select'=>NULL, 
																'Kritik' => 'Critique', 
																'Petisi' => 'Petition', 
																'Proposal' => 'Proposal']) ?>
	<?= $form->field($thread, 'topic')->dropDownList($items, ['Select'=>NULL, 
															'Pendidikan' =>'Education', 
															'Sosial' => 'Social', 
															'Budaya'=>'Culture', 
															'Ekonomi'=>'Economy']) ?>
	<?= $form->field($thread, 'content') ?>
	<?= $form->field($thread, 'photo[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

	<button>Create</button>

<?php ActiveForm::end(); ?>

