<?php
    /** @var $thread_comment \common\entity\ThreadCommentEntity */
    /** @var $is_thread_comment boolean */
?>

<div class="col-xs-12 commentator-comment">
    <?= $this->render('_view_edit_comment_part', ['thread_comment' => $thread_comment,
        'edit_comment_form' => new \backend\models\EditCommentForm(),
        'is_thread_comment' => true

        ]) ?>
</div>

<!-- Votes part-->
<div class="col-xs-4" class="comment-votes">
    <?= $this->render('_comment_votes', [ 'comment' => $thread_comment ,
                                        'is_thread_comment' => $is_thread_comment])?>
</div>

<!-- Child commetn and the button  -->
<?= $this->render('_child_comment', ['thread_comment' => $thread_comment,
    'retrieved' => false,
    'child_comment_form' => new \frontend\models\ChildCommentForm() ]) ?>