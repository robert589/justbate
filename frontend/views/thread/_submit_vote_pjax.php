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
<div class="row" align="center">
    <div class="col-xs-12">
        <h3 style="text-align: center;">Give your vote</h3>
    </div>
    <div class="col-xs-12">
        <div align="center">
            <?php $form = ActiveForm::begin([
                'action' =>   ['thread/submit-vote'],
                'method' => 'post',
                'options' => ['data-pjax' => true]
            ]); ?>
        </div>
        <?= Html::hiddenInput('thread_id', $thread_id) ?>
    </div>

    <div class="col-xs-12" id="vote">
        <!-- User Option -->
        <?= $form->field($submitVoteModel, 'choice_text')->multiselect($thread_choice, ['style' => 'border: 0 !important;', 'selector'=>'radio', 'check' => ['Agree']]) ?>
        <div class="col-xs-12">
            <?php if(isset($user_choice)){ ?>
                <?= Html::submitButton('Vote Again', ['class'=> 'btn btn-primary', 'style' => 'bottom: 0;'])?>
                <?php } else{ ?>
                    <?= Html::submitButton('Vote', ['class'=> 'btn btn-primary']) ?>
                <?php } ?>
                <?php ActiveForm::end(); ?><br />
        </div>
            </div>
        </div>
        <?php Pjax::end(); ?>
        <?php $this->registerJsFile(Yii::$app->request->baseUrl.'/js/thread-submit_vote.js'); ?>
