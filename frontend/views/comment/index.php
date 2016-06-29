<?php
    use yii\helpers\Html;
/** @var $thread_comment \frontend\vo\ThreadCommentVo */

$thread_title = $thread_comment->getParentThreadTitle();
?>

<div class="container-fluid" style="background-color: white">
    <div class="col-xs-12 thread-title">
        <?= Html::encode($thread_title) ?>
    </div>

    <div class="col-xs-12">
        <?= $this->render('thread-comment', ['thread_comment' => $thread_comment]) ?>
    </div>
</div>
