<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Dropdown;
use yii\helpers\ArrayHelper;
use yii\app\models\Thread;
use yii\app\modles\ThreadTopic;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

	<?= $form->field($thread, 'title') ?>
	<?php 

	//$thread_category = thread_category::find()->all();
	//$items = ArrayHelper::map($thread_category, 'category_name' '$thread->category');
	echo $form->field($thread, 'type')->dropDownList(['Select'=>NULL, 
																'Critique' => 'Kritik', 
																'Petition' => 'Petisi', 
																'Proposal' => 'Proposal']) ?>
	<?php 

	//$model = new ThreadTopic;
	//$thread_topic = $model->retrieveAll();
	//$list = ArrayHelper::map($thread_topic, 'topic_name', '$thread->topic');
 	echo $form->field($thread, 'topic_id')->dropDownList(['Select'=>NULL, 
															'1' =>'Pendidikan', 
															'2' => 'Politik']) ?>
	<?= $form->field($thread, 'content') ?>
	<?= $form->field($thread, 'photo[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

	<button>Create</button>

<?php ActiveForm::end(); ?>

