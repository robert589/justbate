<?php
use yii\helpers\Html;

/** @var $anonymous */
/** @var $thread_id */
$anonymous_section_class = "comment-input-anonymous-section-anonymous ";
$non_anonymous_section_class = "comment-input-anonymous-section-non-anonymous ";
if($anonymous ) {
    $non_anonymous_section_class .= 'comment-input-anonymous-hide';
}  else {
    $anonymous_section_class .= 'comment-input-anonymous-hide';
}
?>

<div id="<?= $id ?>">

    <?= Html::hiddenInput('comment-input-anonymous-hi', $anonymous, ['id' => 'comment-input-anonymous-hidden-value-' . $thread_id]) ?>

    <div class="<?= $anonymous_section_class ?>">
        <?= Html::button('<span class="comment-input-anonymous-square glyphicon glyphicon-ok"></span> Anonymous', ['class' => 'button-like-link comment-input-anonymous-cancel-btn',
                        'data-id' => $id, 'data-thread_id' => $thread_id] ) ?>
    </div>
    <div class="comment-input-anonymous-loading-section comment-input-anonymous-hide">
        Loading...
    </div>
    <div class="<?= $non_anonymous_section_class ?>">
        <?= Html::button('<span class="fa fa-square comment-input-anonymous-square-empty"></span> Anonymous',
                        ['class' => 'button-like-link comment-input-anonymous-btn',
                        'data-id' => $id, 'data-thread_id' => $thread_id]) ?>
    </div>
</div>

