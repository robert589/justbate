<?php
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
/** @var $thread \common\entity\ThreadEntity */

$thread_id = $thread->getThreadId();
$thread_choices = $thread->getChoices();
$current_user_choice = $thread->getCurrentUserChoice();

Pjax::begin([
    'id' => 'pjax_user_vote_' . $thread_id,
    'enablePushState' => false,
    'timeout' => false,
    'options' => [
        'container' => '#pjax_user_vote_' . $thread_id
    ]
]);


$propered_choice_text = array();
if(!isset($user_choice_text) || $current_user_choice === null){
    $propered_choice_text[\frontend\models\SubmitThreadVoteForm::USER_HAS_NOT_VOTED] = 'Vote now!';
    $current_user_choice = \frontend\models\SubmitThreadVoteForm::USER_HAS_NOT_VOTED;
}

foreach($thread_choices as $item){
    $item_values = array_values($item);
    $propered_choice_text[$item_values[0]]  = $item_values[0];
}

if($current_user_choice != null){
    $propered_choice_text[\frontend\models\SubmitThreadVoteForm::USER_CHOOSE_NOT_TO_VOTE]  = "Cancel Vote";
}

//Start form
$action = ActiveForm::begin(['action' =>['site/submit-vote'],
    'method' => 'post',
    'id' => 'form_user_vote_' . $thread_id,
    'options' => [ 'data-pjax' => '#pjax_user_vote_' . $thread_id,
                'class' => 'form_user_thread_vote']])
?>
    <?= Html::hiddenInput('user_id' , Yii::$app->user->getId()) ?>

    <?= Html::hiddenInput('thread_id', $thread_id) ?>

<div class="inline">
    <?= Html::dropDownList('user_vote',
                            $current_user_choice ,
                            $propered_choice_text,
                            ['class' => 'form-control user-vote',
                                'data-service' => $thread_id]  )
    ?>
</div>
<?php
ActiveForm::end();
Pjax::end();
?>