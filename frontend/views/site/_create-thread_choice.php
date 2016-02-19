<?php
    use kartik\select2\Select2;
    use yii\helpers\Html;
    use yii\widgets\Pjax;
    use yii\bootstrap\Modal;
?>

<?php Pjax::begin([
    'id' => 'personalized_choice',
    'timeout' => false,
    'enablePushState' => false,
    'clientOptions'=>[
        'container'=>'#personalized_choice',
    ]
]) ?>

<div class="col-xs-3" style="padding-right: 0;">
    <?= $form->field($create_thread_form, 'user_choice')->widget(Select2::className(), [
        'data' => $user_choice,
        'options' => ['placeholder' => 'option ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label(false); ?>

</div>
<div class="col-xs-1">
    <?= Html::button("<span class='glyphicon glyphicon-pencil'></span>", ['class' => 'btn btn-default' , 'id' => 'btn_personalized_choice']) ?>
</div>


<?php
    Modal::begin([
        'id' => 'personalized_choice_modal'
    ]);

    $personalized_choice_form = new \frontend\models\PersonalizedChoiceForm();
    echo $this->render('_personalized_choice_modal', ['personalized_choice_form' => $personalized_choice_form]);

    Modal::end();
?>



<?php Pjax::end() ?>


<?php $this->registerJsFile(Yii::$app->request->baseUrl . '/js/home_create-thread_choice.js'); ?>
