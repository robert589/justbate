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
    <?= ChildCommentInputBox::widget(['id' => $id . '-input-box', 'child_comment_form' => $child_comment_form]) ?>
</div>

    