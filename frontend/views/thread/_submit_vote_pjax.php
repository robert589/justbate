<?php
    use kartik\widgets\SwitchInput;
    use yii\helpers\Html;
	use yii\widgets\Pjax;
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
        <div class="col-md-3 col-md-offset-2">
            <label class="control-label">Give your vote</label>
            <?= Html::beginForm('../thread/submit-vote', 'post', ['id'=>"submitThreadVoteForm" ,
                                                                'data-pjax' => '#submitThreadVote', 'class' => 'form-inline']); ?>

                <?= Html::hiddenInput('voteThread', null, ['id' => 'hiddenInputVoteThread']) ?>
                <?= Html::hiddenInput('thread_id', $thread_id) ?>

                <div class="col-md-6">
                    <?= Html::button('Disagree', ['onclick' => 'disagreeButton()', 'class' => 'btn btn-primary']) ?>
                </div>

                <div class="col-md-6">
                    <?= Html::button('Agree', ['onclick' => 'agreeButton()', 'class' => 'btn btn-default']) ?>

                </div>




            <?= Html::endForm() ?>

        </div>
        <div class="col-md-3">
            <label>Total Yes</label>
            <br>
            0
        </div>
        <div class="col-md-3">
            <label>Total No</label>
            <br>
            0
        </div>
    </div>

<?php Pjax::end(); ?>


<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/js/thread-submit_vote.js'); ?>
