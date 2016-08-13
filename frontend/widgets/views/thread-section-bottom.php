<?php
use yii\helpers\Html;
use common\widgets\LoadingGif;
use frontend\widgets\CommentInputAnonymous;
use common\widgets\ButtonDropdown;

$has_comment = $thread->getCurrentUserComment();
$current_user_has_vote = $thread->getCurrentUserVote();
$thread_id = $thread->getThreadId();
$thread_belongs_to_current_user = $thread->belongToCurrentUser();
$current_user_anonymous = $thread->getCurrentUserAnonymous();
$link_to_thread = $thread->getThreadLink();


$class_for_comment_area = 'thread-section-bottom-button-container ';
$class_for_comment_area .= (!$current_user_has_vote) ? 'thread-section-bottom-hide' : '';
$class_for_vote_area = 'thread-section-bottom-vote-area ';
$class_for_vote_area .= (!$current_user_has_vote) ? '' : 'thread-section-bottom-hide';
?>

<div id="<?= $id ?>" class="thread-section-bottom-container" align="left" data-toggle="buttons">
    <div class="<?= $class_for_vote_area ?>">
        <?= Html::hiddenInput('thread-section-bottom-vote-area-selected-value', $selected,
                ['class' => 'thread-section-bottom-area-selected-value']) ?>
        <?php foreach($items as $value => $text) { ?>
            <?php if($value === $selected) { ?>
            <label class="thread-section-bottom-radio-button btn active disabled"
                    data-id="<?= $id ?>" data-label="<?= $value ?>" data-thread_id = "<?= $thread_id ?>">
            <?php } else { ?>
            <label class="thread-section-bottom-radio-button btn btn-group" 
                   data-id="<?= $id ?>" data-label="<?= $value ?>" data-thread_id = "<?= $thread_id ?>" >
            <?php } ?>
                <div class="simple-button-group-label-<?= str_replace(" ", "-" ,$value) ?>"> 
                    <?= $text ?> 
                </div>
            </label>
        <?php } ?>
    </div>
    <div class="<?= $class_for_comment_area ?>" >
        <div class="thread-section-bottom-left-part">
            
            <?= Html::button('<span class="glyphicon glyphicon-comment"></span> Comment',
                            ['class' => 'thread-section-bottom-comment button-like-link',
                             'data-id' => $id,
                            'data-thread_id' => $thread_id
                            ]) ?>

            <?= Html::button('<span class="glyphicon glyphicon-refresh"></span> Change Vote',
                            ['class' => 'button-like-link thread-section-bottom-change-vote',
                             'data-id' => $id,
                            ]) ?>
            <?= CommentInputAnonymous::widget([ 'id' => 'thread-section-bottom-anonymous-' . $thread_id,
                            'anonymous' => $current_user_anonymous,
                            'thread_id' => $thread_id ]) ?>

        </div>
        <div class="thread-section-bottom-right-part" align="right">
            <div class="fb-share-button">
                <iframe 
                    src="https://www.facebook.com/plugins/share_button.php?href=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&layout=button&size=small&mobile_iframe=true&appId=188756388177786&width=58&height=20" 
                        width="20" height="20" 
                        style="border:none;overflow:hidden" scrolling="no" 
                    frameborder="0" allowTransparency="true">
                </iframe>
            </div>
            <?php if($thread_belongs_to_current_user) { ?>
                <?= ButtonDropdown::widget([
                    'id' => 'thread-section-bottom-button-dropdown-' . $thread_id,
                    'label' => '<span class="glyphicon glyphicon-option-horizontal"></span>',
                    'items' => [
                        [
                            'label' => 'Edit',
                            'class' => 'edit-thread',
                            'data' => $thread_id
                        ],
                        [
                            'label' => 'Delete',
                            'class' => 'delete-thread',
                            'data' => $thread_id
                        ]
                    ]
                ]) ?>    
            <?php } ?>
        </div>
    </div>
    <div class="thread-section-bottom-input-box-loading thread-section-bottom-hide">
        <?=  LoadingGif::widget() ?>
    </div>
    <div class="thread-section-bottom-input-box">
        
    </div>
</div>