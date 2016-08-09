<?php
use yii\helpers\Html;
/** @var $comment_id integer */
/** @var $child_comment_form \frontend\models\ChildCommentForm */
?>

<div id="<?= $id ?>" class="child-comment-input-box-container">
    <div class="child-comment-input-box-form-area">
        <?= Html::textarea('child-comment-input-box-text-area', null,[
            'class' => 'child-comment-input-box-text-area form-control',
            'rows' => 1,
            'placeholder' => 'add comment here..' ]) ?>
        <?= Html::button('Submit',
            ['class' => 'btn btn-sm btn-primary child-comment-input-box-submit-button',
             'data-id' => $id]) ?>
    </div>
    <div class="child-comment-input-box-new-comment-list">
        
    </div>
</div>
