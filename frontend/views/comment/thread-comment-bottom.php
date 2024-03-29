<?php
/** @var $thread_comment \frontend\vo\ThreadCommentVo */
/** @var $is_thread_comment boolean */

use yii\helpers\Html;
use frontend\widgets\ChildCommentList;
use frontend\models\ChildCommentForm;
use common\widgets\ButtonDropdown;
use frontend\widgets\CommentVotes;
$child_comment_request_url = $thread_comment->getChildCommentRequestURL();
$comment_id = $thread_comment->getCommentId();
$thread_id = $thread_comment->getParentThreadId();
$belongs_to_current_user = $thread_comment->isBelongToCurrentUser();
$comment_created_at = $thread_comment->getCreatedAt();
$total_remaining_comment = $thread_comment->getTotalRemainingComment();

?>

<div class="commentator-comment">
    <?= $this->render('comment-section', ['thread_comment' => $thread_comment,
        'edit_comment_form' => new \frontend\models\EditCommentForm(),
        'is_thread_comment' => true  ]) ?>
    
</div>
<div class="thread-comment-bottom-button">
    <div class="thread-comment-votes" > 
            <?= CommentVotes::widget(['id' => 'comment-votes-' . $comment_id, 'comment' => $thread_comment]) ?>
        <span class="thread-comment-created-time">
            <?= $comment_created_at ?>
        </span>
    </div>

    <?php if($belongs_to_current_user) { ?>
    <div class="thread-comment-bottom-button-dropdown" align="right">
        <?= ButtonDropdown::widget([
            'id' => 'comment-button-dropdown-' . $comment_id,
            'label' => '<span class="glyphicon glyphicon-option-horizontal"></span>',
            'items' => [
                [
                    'label' => 'Edit',
                    'class' => 'edit_comment',
                    'data' => $comment_id
                ],
                [
                    'label' => 'Delete',
                    'class' => 'delete_comment',
                    'data' => $comment_id
                ]
            ]
        ]) ?>
    </div>
    <?php } ?>
</div>
<div  align="center" class="col-xs-12" >
    <?= Html::img(Yii::$app->request->baseUrl . '/frontend/web/img/loading.gif',
        ['style' => 'display:none;max-height:50px' ,
        'id' => 'child_comment_loading_gif_' . $comment_id])?>
</div>

<?= ChildCommentList::widget(['id' => 'child-comment-list-container-' . $comment_id, 
                            'comment_id' => $comment_id,
                            'total_remaining_comment' => $total_remaining_comment,
                            'chosen_child_comment' => $thread_comment->getChosenComment(),
                            'child_comment_form' => new ChildCommentForm()]); ?>
