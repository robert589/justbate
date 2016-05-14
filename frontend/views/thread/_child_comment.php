<?php

// rendered from _listview_comment
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\bootstrap\ActiveForm;
use common\models\CommentVote;
use kartik\dialog\Dialog;
/** @var $comment_id integer */
/** @var $thread_id  integer */
/** @var $belongs boolean */
/** @var $retrieved boolean */
/** @var $child_comment_form \frontend\models\ChildCommentForm */
/** @var $child_comment_provider \yii\data\ArrayDataProvider */

?>

<?php Pjax::begin([
    'id' => 'child_comment_'  . $comment_id,

    'options'=>[
        'class' => 'child_comment_pjax',
        'data-service' => $comment_id,
        'container'=>'#child_comment_' . $comment_id,
    ],


]) ?>

<?= Dialog::widget(); ?>

<div class="col-md-8">
    <?php if($belongs){ ?>
        <?= Html::button('Edit', ['class' => 'btn btn-primary inline edit_comment', 'data-service' => $comment_id]) ?>
        <?= Html::button('Delete', ['class' => 'btn btn-danger inline delete_comment', 'data-service' => $comment_id]) ?>
    <?php } ?>

    <?= Html::a("Comment",
            Yii::$app->request->baseUrl . '/thread/get-child-comment?thread_id=' . $thread_id . '&comment_id=' . $comment_id ,
            ['class' => 'btn btn-primary inline retrieve-child-comment-link',
                        'data-pjax' => "#child_comment_$thread_id",
                        'data-service' => $comment_id, 'style' => 'margin-left:15px']) ?>

    <?= Html::hiddenInput('child_comment_url', \yii\helpers\Url::to(['thread/get-sse-child-comment', 'comment_id' => $comment_id,
        'last_time' =>  time() , ['id' => 'child_comment_url_' . $comment_id]   ])) ?>
</div>


<div  align="center" class="col-xs-12" >
    <?= Html::img(Yii::$app->request->baseUrl . '/frontend/web/img/loading.gif', ['style' => 'display:none;max-height:50px' , 'id' => 'child_comment_loading_gif_' . $thread_id ]) ?>
</div>




<?php if($retrieved){ ?>

<div class="col-xs-12" style="background-color: #dff0d8; " id="<?= 'comment_part_' . $comment_id ?>">
    <div class="col-xs-12" style="margin-top: 15px;" >
        <?= $this->render('_child_comment_input_box', ['comment_id' => $comment_id, 'child_comment_form' => $child_comment_form]) ?>
    </div>


    <div class="col-xs-12">

        <div id="child_comment_sse_<?= $comment_id ?>" >

        </div>

        <?= ListView::widget([
            'id' => 'threadList',
            'dataProvider' => $child_comment_provider,
            'summary' => false,
            'itemOptions' => ['class' => 'item'],
            'layout' => "{summary}\n{items}\n{pager}",
            'itemView' => function ($model, $key, $index, $widget) {
                $comment_vote_form = CommentVote::getCommentVotesOfComment($model['comment_id'], Yii::$app->getUser()->getId());
                return $this->render('_listview_child_comment',['model' => $model, 'total_like' => $comment_vote_form['total_like'],
                                'total_dislike' => $comment_vote_form['total_dislike'], 'vote' => $comment_vote_form['vote']]);
            }

        ]) ?>
    </div>
</div>


<?php } ?>


<?php $form = ActiveForm::begin(['action' => ['thread/delete-comment'], 'method' => 'post', 'id' => 'delete_comment_form_' . $comment_id]) ?>
    <?= Html::hiddenInput('comment_id', $comment_id) ?>
    <?= Html::hiddenInput('thread_id', $thread_id) ?>

<?php ActiveForm::end() ?>

<?php Pjax::end() ?>
