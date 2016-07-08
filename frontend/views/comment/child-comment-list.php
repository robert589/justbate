<?php

// rendered from _listview_comment
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\bootstrap\ActiveForm;
use common\models\CommentVote;
use kartik\dialog\Dialog;
use WebSocket\Client;

/** @var $thread_comment \frontend\vo\ThreadCommentVo */
/** @var $retrieved boolean */
/** @var $child_comment_form \frontend\models\ChildCommentForm */
/** @var $child_comment_provider \yii\data\ArrayDataProvider */

/**
* Variable Used
*/
$comment_id = $thread_comment->getCommentId();
$belongs_to_current_user = $thread_comment->isBelongToCurrentUser();
$thread_id = $thread_comment->getParentThreadId();
$child_comment_request_url = $thread_comment->getChildCommentRequestURL();

?>

<?php Pjax::begin([
    'id' => 'child_comment_'  . $comment_id,
    'options'=>[
        'class' => 'child_comment_pjax',
        'data-service' => $comment_id,
        'container'=>'#child_comment_' . $comment_id,
    ],
]);

?>

<?php
    if($thread_comment->isRetrieved()) {
        $child_comment_provider = $thread_comment->getChildCommentList();
    ?>
        <div class="col-xs-12" style="background-color: #dff0d8; " id="<?= 'comment_part_' . $comment_id ?>">
            <div class="col-xs-12" style="margin-top: 15px;">
                <?= $this->render('child-comment-input-box', ['comment_id' => $comment_id,
                                                              'child_comment_form' => $child_comment_form]) ?>
            </div>
            <div class="col-xs-12 text-center">
                <div id="child-comment-list-new-comment-<?= $comment_id ?>">
                </div>
                <?= ListView::widget([
                    'id' => 'threadList',
                    'dataProvider' => $child_comment_provider,
                    'summary' => false,
                    'itemOptions' => ['class' => 'item'],
                    'layout' => "{summary}\n{items}\n{pager}",
                    'itemView' => function ($child_comment, $key, $index, $widget) {
                        return $this->render('child-comment', ['child_comment' => $child_comment]);
                    }
                ]) ?>
            </div>
        </div>
    <?php } ?>
<?php $form = ActiveForm::begin(['action' => ['comment/delete-comment'],
                                'method' => 'post',
                                'id' => 'delete_comment_form_' . $comment_id]) ?>
    <?= Html::hiddenInput('comment_id', $comment_id) ?>
    <?= Html::hiddenInput('thread_id', $thread_id) ?>
<?php ActiveForm::end() ?>
<?php Pjax::end() ?>
