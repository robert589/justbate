<?php
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
/** @var $submitVoteModel \frontend\models\SubmitThreadVoteForm */
/** @var $thread_choices array */
/** @var $thread_id integer */

// $choice_and_voters array
$choice_and_voters = array();
//prepare data
foreach($thread_choices as $thread_choice){
    $choice_and_voters[$thread_choice['choice_text']] =$thread_choice['choice_text'] . '( ' . $thread_choice['total_voters'] . ' )';
}

?>

<?php $form = ActiveForm::begin([
    'action' =>   ['thread/submit-vote'],
    'method' => 'post',
    'id' => 'from_submit_vote',
    'options' => [   'data-pjax' => '#edit_thread']
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
        <?= $form->field($submitVoteModel, 'choice_text')->multiselect($choice_and_voters, ['style' => 'border: 0 !important;', 'selector'=>'radio', 'check' => ['Agree']]) ?>

        <!-- Submit vote-->
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
