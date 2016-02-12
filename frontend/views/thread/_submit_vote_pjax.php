<?php
    use kartik\widgets\ActiveForm;
    use yii\helpers\Html;
	use yii\widgets\Pjax;

    //using pjax, the data sent is not $model['thread_id'] but $thread_id
    if(!isset($thread_id)){
        $thread_id = $model['thread_id'];
    }
    //using pjax, the data sent is not from model but $user_choice
    if(!isset($user_choice)){
        $user_choice = $model['user_choice'];
    }

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
            <div align="center">
                <h3>Give your vote</h3>

            </div>
            <?php $form = ActiveForm::begin(['action' =>   ['thread/submit-vote'],
                                            'method' => 'post',
                                            'options' =>['data-pjax' => true]
                                            ]); ?>

            <?= Html::hiddenInput('thread_id', $thread_id) ?>


            <!-- User Option -->
            <?= $form->field($submitVoteModel, 'choice_text')->multiselect($thread_choice, ['selector'=>'radio', 'check' => ['Agree']]) ?>


            <?php if(isset($user_choice)){ ?>
                <?= Html::submitButton('Vote Again', ['class'=> 'btn btn-primary']) ?>
                <label>You voted for <?= $user_choice?></label>

            <?php } else{ ?>
                <?= Html::submitButton('Vote', ['class'=> 'btn btn-primary']) ?>

            <?php } ?>
            <?php ActiveForm::end(); ?>
            <hr>
        </div>


    </div>

<?php Pjax::end(); ?>


<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/js/thread-submit_vote.js'); ?>
