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

<?php $form = ActiveForm::begin([
    'action' =>   ['thread/submit-vote'],
    'method' => 'post',

    'options' => ['id' => 'form_submit_vote', 'data-pjax' => '#submitThreadVote']
]); ?>


<?php
    if(isset($trigger_login_form) && $trigger_login_form == true){
        echo 'You need to login to perform this action, click ' . Html::a('Login','', ['id' => 'login_link']) ;
    }
?>
<!--Give Votes Part-->
<div class="row" align="center">

    <?= Html::hiddenInput('thread_id', $thread_id) ?>

    <div class="col-xs-12" id="vote">
        <!-- User Option -->
        <?= $form->field($submitVoteModel, 'choice_text')->multiselect($thread_choice, ['style' => 'border: 0 !important;', 'selector'=>'radio', 'check' => ['Agree']]) ?>
        <div class="col-xs-12">
            <?php if(isset($user_choice)){ ?>
               <?= Html::submitButton('Vote Again', ['id' => 'btn_submit_vote', 'class'=> 'btn btn-primary', 'style' => 'bottom: 0;'])?>
            <?php } else{ ?>
                <?= Html::submitButton('Vote', ['id' => 'btn_submit_vote', 'class'=> 'btn btn-primary']) ?>
            <?php } ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
<br>
<?php Pjax::end(); ?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/js/thread-submit_vote.js'); ?>
