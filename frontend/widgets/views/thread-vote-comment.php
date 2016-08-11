<?php
/** @var $class string **/
/** @var $items array **/
/** @var $id string **/
/** @var $arg string **/
/** @var $item_class string **/
$has_comment = $thread->getCurrentUserComment();
$current_user_has_vote = $thread->getCurrentUserVote();
$thread_id = $thread->getThreadId();
use yii\helpers\Html;
use common\widgets\LoadingGif;

$class_for_comment_area = 'thread-vote-comment-button-container ';
$class_for_comment_area .= (!$current_user_has_vote) ? 'thread-vote-comment-hide' : '';
$class_for_vote_area = 'thread-vote-comment-vote-area ';
$class_for_vote_area .= (!$current_user_has_vote) ? '' : 'thread-vote-comment-hide';
?>

<div id="<?= $id ?>" class="thread-vote-comment-container" align="left" data-toggle="buttons">
    <div class="<?= $class_for_vote_area ?>">
        <?= Html::hiddenInput('thread-vote-coment-vote-area-selected-value', $selected,
                ['class' => 'thread-comment-vote-area-selected-value']) ?>
        <?php foreach($items as $value => $text) { ?>
            <?php if($value === $selected) { ?>
            <label class="thread-vote-comment-radio-button btn active disabled"
                    data-id="<?= $id ?>" data-label="<?= $value ?>" data-thread_id = "<?= $thread_id ?>">
            <?php } else { ?>
            <label class="thread-vote-comment-radio-button btn btn-group" 
                   data-id="<?= $id ?>" data-label="<?= $value ?>" data-thread_id = "<?= $thread_id ?>" >
            <?php } ?>
                <div class="simple-button-group-label-<?= str_replace(" ", "-" ,$value) ?>"> 
                    <?= $text ?> 
                </div>
            </label>
        <?php } ?>
    </div>
    <div class="<?= $class_for_comment_area ?>" >
        <?= Html::button('<span class="glyphicon glyphicon-comment"></span> Comment',
                        ['class' => 'thread-vote-comment-comment button-like-link',
                         'data-id' => $id,
                            'data-thread_id' => $thread_id
                        ]) ?>
        
        <?= Html::button('<span class="glyphicon glyphicon-refresh"></span> Change Vote',
                        ['class' => 'button-like-link thread-vote-comment-change-vote',
                         'data-id' => $id,
                        ]) ?>
    </div>
    <div class="thread-vote-comment-input-box-loading thread-vote-comment-hide">
        <?=  LoadingGif::widget() ?>
    </div>
    <div class="thread-vote-comment-input-box">
        
    </div>
</div>