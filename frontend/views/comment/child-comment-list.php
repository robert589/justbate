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

    <?= Dialog::widget(); ?>
    <div class="inline">
        <?= Html::a("Comment",    $child_comment_request_url,
                    ['class' => 'btn btn-primary inline retrieve-child-comment-link',
                    'data-pjax' => "#child_comment_$thread_id",
                    'data-service' => $comment_id,
                    'style' => 'margin-left:15px; float:left'])?>
        <?php if($belongs_to_current_user){ ?>
            <div id="dropdown-button" role="group" aria-label="group" class="btn-group dropdown-toggle" type="button" data-toggle="dropdown">
                <button class="btn btn-secondary" type="button"><span class="glyphicon glyphicon-chevron-down"></span></button>
                <ul class="dropdown-menu" id="comment-options">
                    <li data-service="<?= $comment_id ?>" class="item edit_comment"><a href="#">Edit</a></li>
                    <li data-service="<?= $comment_id ?>" class="item delete-comment"><a href="#">Delete</a></li>
                </ul>
            </div>
            <?php } ?>
        </div>
        <div  align="center" class="col-xs-12" >
            <?= Html::img(Yii::$app->request->baseUrl . '/frontend/web/img/loading.gif',
            ['style' => 'display:none;max-height:50px' ,
            'id' => 'child_comment_loading_gif_' . $comment_id])?>
        </div>
        <?php
        if($thread_comment->isRetrieved()) {
            $child_comment_provider = $thread_comment->getChildCommentList();
        ?>
            <div class="col-xs-12" style="background-color: #dff0d8; " id="<?= 'comment_part_' . $comment_id ?>">
                <div class="col-xs-12" style="margin-top: 15px;">
                    <?= $this->render('child-comment-input-box', ['comment_id' => $comment_id, 'child_comment_form' => $child_comment_form]) ?>
                </div>
                <div class="col-xs-12 text-center">
                    <div id="child-comment-input-box-new-comment">
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
