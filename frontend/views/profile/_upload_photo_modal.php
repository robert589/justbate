<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>



<?php $form = ActiveForm::begin(['action' => 'upload', 'options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'imageFile')->widget(\bupy7\cropbox\Cropbox::className(),[
        'attributeCropInfo' => 'crop_info'

    ]) ?>

    <?= Html::submitButton('Upload', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end() ?>