<?php
/** @var $thread_comment \common\entity\ThreadCommentEntity */
/** @var $is_thread_comment boolean */
?>

<div class="col-xs-12 commentator-comment">
    <?= $this->render('comment-section', ['thread_comment' => $thread_comment,
        'edit_comment_form' => new \backend\models\EditCommentForm(),
        'is_thread_comment' => true  ]) ?>
</div>

<div class="inline" class="comment-votes" style="margin-left: 12px">
    <?= $this->render('comment-votes', [ 'comment' => $thread_comment ,
        'is_thread_comment' => $is_thread_comment])?>
</div>

<?= $this->render('_child_comment', ['thread_comment' => $thread_comment,
    'retrieved' => false,
    'child_comment_form' => new \frontend\models\ChildCommentForm() ]) ?>