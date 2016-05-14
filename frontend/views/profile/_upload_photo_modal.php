<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
/** @var $model \frontend\models\UploadProfilePicForm */
?>
<?php $form = ActiveForm::begin(['action' => ['profile/upload'],'method' => 'post', 'options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'imageFile')->widget(\kartik\widgets\FileInput::className(),[
    'pluginOptions' => [
        'showCaption' => false,
        'showRemove' => false,
        'showUpload' => false,
        'browseClass' => 'btn btn-primary btn-block',
        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
        'browseLabel' =>  'Select Photo'
    ],
    'options' => ['accept' => 'image/*']
    ]) ?>

    <?= Html::submitButton('Upload', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end() ?>