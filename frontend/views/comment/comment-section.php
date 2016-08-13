<?php
//Rendered from: _listview_comment
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
/** @var $thread_comment \common\entity\ThreadCommentEntity */
/** @var $comment string */
/** @var $edit_comment_form \frontend\models\EditCommentForm */

/**
 * USED VARIABLE
 */
$comment_id = $thread_comment->getCommentId();
$comment = $thread_comment->getComment();

?>

<div id="comment_shown_part_<?= $comment_id ?>">
    <?= \common\widgets\SimpleSeeMore::widget(['text' => $comment, 
                                'active' => false, 
                                'id' => 'comment-section-comment'. $comment_id ]) ?>
</div>

<div id="comment_edit_part_<?= $comment_id ?>" style="display: none" >
    <?php $form = ActiveForm::begin([
        'id' => 'comment-section-edit-form-' . $comment_id,
        'action' => ['thread/edit-comment'], 'method' => 'post',
        'options' => [
            'data-pjax' => '#edit_comment_pjax_' . $comment_id,
            'class' => 'comment-section-edit-form',
        ]
    ])?>

        <?= Html::textarea('comment',\yii\helpers\HtmlPurifier::process($comment), [
            'id' => 'comment-section-edit-redactor-' . $comment_id
        ]) ?>

        <?= $form->field($edit_comment_form, 'parent_id')->hiddenInput(['value' => $comment_id ])->label(false) ?>

        <div align="right" class="row">
            <?= Html::button('Update', ['class' => 'btn update-comment-btn btn-sm btn-primary', 'data-service' => $comment_id]) ?>
            <?= Html::button('Cancel', ['class' => 'btn btn-sm btn-danger cancel_edit_comment', 'data-service' => $comment_id]) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div>