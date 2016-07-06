<?php
use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
/** @var $thread \frontend\vo\ThreadVo */
/** @var $submit_thread_vote_form \frontend\models\SubmitThreadVoteForm */

/**
 * Variable Used
 */
$thread_id = $thread->getThreadId();

Pjax::begin([
    'id' => 'pjax_user_vote_' . $thread_id,
    'enablePushState' => false,
    'timeout' => false,
    'options' => [
        'class' => 'pjax_user_vote',
        'data-service' => $thread_id,
        'container' => '#pjax_user_vote_' . $thread_id
    ]
]);
/**
 * Variable used
 */
$thread_id = $thread->getThreadId();
$submit_thread_vote_form->thread_id = $thread_id;
$thread_choices = $thread->getMappedChoices();
$current_user_choice = $thread->getCurrentUserVote();
$submit_thread_vote_form->choice_text = $current_user_choice;
$propered_choice_text = array();
foreach($thread_choices as $item){
    $item_values = array_values($item);
    $propered_choice_text[$item_values[0]]  = $item_values[0] . " (" . $item['total_voters'] . ")";
}

    //Start form
    $form = ActiveForm::begin(['action' =>['thread/submit-vote'],
        'method' => 'post',
        'id' => 'form_user_vote_' . $thread_id,
        'options' => [ 'data-pjax' => '#pjax_user_vote_' . $thread_id,
                    'class' => 'form_user_thread_vote']]
    )
?>
        <?= $form->field($submit_thread_vote_form, 'thread_id')->hiddenInput() ?>

        <div align="center">
            <?= $form->field($submit_thread_vote_form, 'choice_text')
                     ->radioButtonGroup($propered_choice_text,
                                        ['class' => 'btn-group-md user-vote',
                                         'data-service' => $thread_id,
                                         'disabledItems' => [$submit_thread_vote_form->choice_text],
                                         'itemOptions' => ['labelOptions' =>
                                                            ['class' => 'btn btn-md btn-warning'
                                                            ]
                                                        ]
                                        ]) ?>
        </div>

<?php
    ActiveForm::end();
Pjax::end();
?>
