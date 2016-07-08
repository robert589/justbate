<?php
/** @var $thread_comment \frontend\vo\ThreadCommentVo */
/** @var $is_thread_comment boolean */

use yii\helpers\Html;

$child_comment_request_url = $thread_comment->getChildCommentRequestURL();
$comment_id = $thread_comment->getCommentId();
$thread_id = $thread_comment->getParentThreadId();
$belongs_to_current_user = $thread_comment->isBelongToCurrentUser();

?>

<div class="col-xs-12 commentator-comment">
    <?= $this->render('comment-section', ['thread_comment' => $thread_comment,
    'edit_comment_form' => new \frontend\models\EditCommentForm(),
    'is_thread_comment' => true  ]) ?>
</div>

<div class="inline" class="comment-votes">
    <?= $this->render('comment-votes', [ 'comment' => $thread_comment ,
    'is_thread_comment' => $is_thread_comment])?>
</div>

<div class="inline">
    <?= Html::a("Comment",    $child_comment_request_url,
    ['class' => 'btn btn-sm btn-primary inline retrieve-child-comment-link',
    'data-pjax' => "#child_comment_$thread_id",
    'data-service' => $comment_id,
    'style' => 'margin-left:15px; float:left'])?>
    <?php if($belongs_to_current_user) { ?>
        <div class="inline" style="margin-left: 15px;">
            <input type="checkbox" id="dropdown-comment-input-<?= $comment_id ?>" />
            <label for="dropdown-comment-input-<?= $comment_id ?>"><span class="glyphicon glyphicon-chevron-down"></span></label>
            <table id="user-table-comment-<?= $comment_id ?>">
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

<?= $this->render('child-comment-list', ['thread_comment' => $thread_comment,
                                        'retrieved' => false,
                                        'child_comment_form' => new \frontend\models\ChildCommentForm() ]) ?>
