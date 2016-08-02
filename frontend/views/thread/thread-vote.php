<?php
use yii\helpers\HTMLPurifier;
use yii\helpers\Html;
use common\widgets\SimpleRadioButton;
/** @var $thread \frontend\vo\ThreadVo */
/** @var $submit_thread_vote_form \frontend\models\SubmitThreadVoteForm */
$thread_id = $thread->getThreadId();
$submit_thread_vote_form->thread_id = $thread_id;
$thread_choices = $thread->getMappedChoices();
$current_user_choice = $thread->getCurrentUserVote();
$submit_thread_vote_form->choice_text = $current_user_choice;
$propered_choice_text = array();
foreach($thread_choices as $item){
    $item_values = array_values($item);
    $propered_choice_text[$item_values[0]]  = HTMLPurifier::process($item_values[0] . " (" . $item['total_voters'] . ")");
}
?>

<div class="col-xs-12" id="thread-vote-<?= $thread_id ?>" >
    <?= Html::hiddenInput('thread-vote-old-value', $submit_thread_vote_form->choice_text,
                        ['id' => 'thread-vote-old-value-' . $thread_id]) ?>

    <div align="left">
        <span class="thread-vote-label">
            <u>
                Vote Here:
            </u>
        </span>
            
            <?= SimpleRadioButton::widget(['items' => $propered_choice_text, 
                'selected' => $submit_thread_vote_form->choice_text,
                'id' => 'thread-vote-radio-button-' . $thread_id,
                'item_class' => 'thread-vote-radio-button',
                'widget_class' => 'inline',
                'arg' => $thread_id]) ?>

    </div>
</div>
