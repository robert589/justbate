<?php
use yii\helpers\Html;

/** @var $anonymous */
/** @var $thread_id */
?>

<?= Html::hiddenInput('comment-input-anonymous-hi', $anonymous, ['id' => 'comment-input-anonymous-hidden-value-' . $thread_id]) ?>

<div id="comment-input-anonymous-section-<?= $thread_id ?>">
    <div id="comment-input-anonymous-section-anonymous-<?= $thread_id ?>"
        <?php if(!$anonymous){ echo 'style="display: none"';}  ?>>
            <?= Html::button('Cancel Anonymous', ['class' => 'btn btn-sm btn-default comment-input-anonymous-cancel-btn',
                        'id' => 'comment-input-anonymous-cancel-btn-' . $thread_id,
                        'data-service' => $thread_id] ) ?>
    </div>
    <div id="comment-input-anonymous-section-non-anonymous-<?= $thread_id ?>"
        <?php if($anonymous){ echo 'style="display: none"';}  ?>>
        <?= Html::button('Go Anonymous',
                        ['class' => 'btn btn-sm btn-default comment-input-anonymous-btn',
                        'id' => 'comment-input-anonymous-btn-' . $thread_id,
                        'data-service' => $thread_id]) ?>
    </div>
</div>

