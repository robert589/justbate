<?php
/** @var $navigationText array */
/** @var $requestUrl string */
/** @var $id string */
/** @var $perPage string */
/** @var $totalCount int */
use \yii\helpers\Html;
use frontend\widgets\ChildCommentInputBox;
?>
    
<div class="child-comment-list-container" id="<?= $id ?>">
    <?= ChildCommentInputBox::widget(['id' => $id . '-input-box','parent_id' => $comment_id, 'child_comment_form' => $child_comment_form]) ?>
    <div class="child-comment-list-area">
        
    </div>
    <div class="child-comment-list-button">
        <?= Html::button('Load comments (3+)', ['class' => 'child-comment-list-button-load button-like-link']) ?>
    </div>
</div>

    