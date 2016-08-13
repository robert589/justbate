<?php
/** @var $navigationText array */
/** @var $requestUrl string */
/** @var $id string */
/** @var $perPage string */
/** @var $totalCount int */
use \yii\helpers\Html;
use frontend\widgets\ChildCommentInputBox;
use frontend\widgets\ChildComment;
use common\widgets\LoadingGif;
$has_comment = ($chosen_child_comment->getCommentId() !== null);
$button_area_class = 'child-comment-list-button';

if($total_remaining_comment === 0 ){ 
    $button_area_class .= ' child-comment-list-hide';
    
} 
?>
    
<div class="child-comment-list-container" id="<?= $id ?>">
    <?= ChildCommentInputBox::widget(['id' => $id . '-input-box',
        'parent_id' => $comment_id, 'child_comment_form' => $child_comment_form]) ?>
    
    <div class="child-comment-list-area">
        <div class="child-comment-list-area-comment-area">
            <?php if($has_comment) { ?>
                <?= ChildComment::widget(['child_comment' => $chosen_child_comment, 
                    'id' => 'child-comment-' . $chosen_child_comment->getCommentId()]) ?>
            <?php } ?>
        </div>
        <div class="child-comment-list-loading child-comment-list-hide">
            <?= LoadingGif::widget() ?>
        </div>
        <div class="<?= $button_area_class ?>">
            <?= Html::button("Load comments (<span class='child-comment-list-total-remaining'>$total_remaining_comment</span>+)", 
                    ['class' => 'child-comment-list-button-load button-like-link',
                        'data-id' => $id, 'data-comment_id' => $comment_id]) ?>
        </div>
        
    </div>
    <?= Html::hiddenInput('child-comment-list-last-time',
            $has_comment ? $chosen_child_comment->getCreatedAtUnixTimestamp() : null, 
            ['class' => 'child-comment-list-last-time'])
                    ?>
</div>

    