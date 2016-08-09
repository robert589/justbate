<?php
/** @var $thread_comment \frontend\vo\ThreadCommentVo */
/** @var $is_thread_comment boolean */

use yii\helpers\Html;
use frontend\widgets\ChildCommentList;
use frontend\models\ChildCommentForm;
$child_comment_request_url = $thread_comment->getChildCommentRequestURL();
$comment_id = $thread_comment->getCommentId();
$thread_id = $thread_comment->getParentThreadId();
$belongs_to_current_user = $thread_comment->isBelongToCurrentUser();

?>

<div class="commentator-comment">
    <?= $this->render('comment-section', ['thread_comment' => $thread_comment,
        'edit_comment_form' => new \frontend\models\EditCommentForm(),
        'is_thread_comment' => true  ]) ?>
    
</div>
<div class="thread-comment-bottom-button">
    <div class="comment-votes inline" > 
        <?= $this->render('comment-votes', [ 'comment' => $thread_comment ,
        'is_thread_comment' => $is_thread_comment])?>
    </div>

    <?php if($belongs_to_current_user) { ?>
    <div class="thread-comment-bottom-button-dropdown" align="right">
        <input type="checkbox" id="dropdown-comment-input-<?= $comment_id ?>" />
        <?=        
            Html::button('<span class="glyphicon glyphicon-option-horizontal"></span>', 
                    ['class' => 'button-like-link thread-comment-bottom-dropdown-label']) ?>

        <table id="user-table-comment-<?= $comment_id ?>" data-service="<?= $comment_id ?>">
            <tbody>
                <tr><td><button data-service="<?= $comment_id ?>" class="edit_comment inner btn btn-block btn-default">Edit</button></td></tr>
                <tr><td><button data-service="<?= $comment_id ?>" class="delete-comment inner btn btn-block btn-danger">Delete</button></td></tr>
            </tbody>
        </table>
    </div>
    <?php } ?>
</div>
<div  align="center" class="col-xs-12" >
    <?= Html::img(Yii::$app->request->baseUrl . '/frontend/web/img/loading.gif',
        ['style' => 'display:none;max-height:50px' ,
        'id' => 'child_comment_loading_gif_' . $comment_id])?>
</div>

<?= ChildCommentList::widget(['id' => 'child-comment-list-container-' . $comment_id, 
                                    'child_comment_form' => new ChildCommentForm()]); ?>
