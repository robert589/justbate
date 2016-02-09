<?php
    use kartik\widgets\ActiveForm;
    use yii\helpers\Html;
	use yii\widgets\Pjax;

    //Store this variable for javascript
    if(!empty(\Yii::$app->user->isGuest)){
        $guest = "1";

    }
    else{
        $guest = "0";
    }

?>

<?php Pjax::begin([
    'id' => 'submitThreadVote',
    'timeout' => false,
    'enablePushState' => false,
    'clientOptions'=>[
        'container' => '#submitThreadVote',
    ]
]);?>

    <!--Give Votes Part-->
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <label class="control-label">Give your vote</label>
            <?php $form = ActiveForm::begin(['action' =>   ['thread/submit-vote'],
                                            'method' => 'post',
                                            'options' =>['data-pjax' => true]
                                            ]); ?>
                <?= Html::hiddenInput('voteThread', null, ['id' => 'hiddenInputVoteThread']) ?>
                <?= Html::hiddenInput('thread_id', $model['thread_id']) ?>
                <!-- User Option -->
                <?= $form->field($submitVoteModel, 'choice_text')->multiselect($thread_choice, ['selector'=>'radio']) ?>
                <?= Html::submitButton('Submit', ['class'=> 'btn btn-primary']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

<?php Pjax::end(); ?>


<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/js/thread-submit_vote.js'); ?>
