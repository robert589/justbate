<?php
    use kartik\widgets\SwitchInput;
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
        <div class="col-md-3 col-md-offset-2">
            <label class="control-label">Give your vote</label>
            <?= Html::beginForm('../thread/submit-vote', 'post', ['id'=>"submitThreadVoteForm" ,
                                                                'data-pjax' => '#submitThreadVote', 'class' => 'form-inline']); ?>

                <?= Html::hiddenInput('voteThread', null, ['id' => 'hiddenInputVoteThread']) ?>
                <?= Html::hiddenInput('thread_id', $thread_id) ?>

            <?php if($guest == "0"){ ?>
                <div class="col-md-6">
                    <?php if($model['current_user_vote'] == 1){ ?>
                        <?= Html::button('Disagree', ['onclick' => 'disagreeButton()', 'class' => 'btn btn-primary']) ?>
                    <?php }else{ ?>
                        <?= Html::button('Disagree', ['onclick' => 'disagreeButton()', 'class' => 'btn btn-primary', 'disabled' => true]) ?>

                    <?php } ?>
                </div>

                <div class="col-md-6">
                    <?php if($model['current_user_vote'] == 1){ ?>
                        <?= Html::button('Agree', ['onclick' => 'agreeButton()', 'class' => 'btn btn-default', 'disabled' => true]) ?>
                    <?php }else{ ?>
                        <?= Html::button('Agree', ['onclick' => 'agreeButton()', 'class' => 'btn btn-default']) ?>

                    <?php } ?>

                </div>
            <?php }else{  ?>
                <div class="col-md-6">
                        <?= Html::button('Disagree', ['onclick' => 'beginLoginModal()', 'class' => 'btn btn-primary']) ?>

                </div>

                <div class="col-md-6">
                        <?= Html::button('Agree', ['onclick' => 'beginLoginModal()', 'class' => 'btn btn-default']) ?>


                </div>
            <?php } ?>



            <?= Html::endForm() ?>

        </div>
        <div class="col-md-3">
            <label>Total Yes</label>
            <br>
            <?= $model['total_agree'] ?>
        </div>
        <div class="col-md-3">
            <label>Total No</label>
            <br>
            <?= $model['total_disagree']?>
        </div>
    </div>

<?php Pjax::end(); ?>


<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/js/thread-submit_vote.js'); ?>
