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

<?= Html::hiddenInput('comment-input-anonymous-hi', $anonymous, ['id' => 'comment-input-anonymous-hidden-value-' . $thread_id]) ?>

<div id="<?= $id ?>">
    <div class="<?= $anonymous_section_class ?>">
        <?= Html::button('Known', ['class' => 'button-like-link comment-input-anonymous-cancel-btn',
                        'data-id' => $id] ) ?>
    </div>
    <div class="<?= $non_anonymous_section_class ?>">
        <?= Html::button('Anonymous',
                        ['class' => 'button-like-link comment-input-anonymous-btn',
                        'data-id' => $id]) ?>
    </div>
</div>

