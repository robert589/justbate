<?php
use dosamigos\ckeditor\CKEditor;

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Dropdown;
use yii\helpers\ArrayHelper;
use yii\app\models\Thread;
use yii\app\models\ThreadTopic;
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

	<?= $form->field($thread, 'title') ?>
	

	<?= $form->field($thread, 'content')->widget(CKEditor::className(), [
        'options' => ['rows' => 15],
        'preset' => 'full'
    ]) ?>

<?= $form->field($thread, 'type')->dropDownList(['Select'=>NULL, 
																'Critique' => 'Kritik', 
																'Petition' => 'Petisi', 
																'Proposal' => 'Proposal']) ?>

  	<?= $form->field($thread, 'topic_id')->dropDownList(['Select'=>NULL, 
															'1' =>'Pendidikan', 
															'2' => 'Politik']) ?>



	<?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>

