<?php
//retrieve from _list_thread_bottom

use yii\widgets\Pjax;
use yii\bootstrap\Html;
use yii\widgets\ActiveForm;

/** @var $thread \common\entity\ThreadEntity */
/** @var $total_comments integer */
/** @var $comment_providers \yii\data\ArrayDataProvider */
/** @var $comment_retrieved boolean */

/**
 * Variable Used in this Pjax View
 */
$thread_id = $thread->getThreadId();
Pjax::begin([
    'id' => 'comment_section_' . $thread_id,
    'options' => [
        'class' => 'comment_section_pjax',
        'data-service' => $thread_id,
        'container' => '#comment_section_' . $thread_id
    ]
])



?>

<?php
    if(isset($comment_retrieved)){
        /* Variable used in this if block   */
        $total_comments = $thread->getTotalComment();
        $comment_providers = $thread->getCommentList();
        $thread_id = $thread->getThreadId();

?>
        <?= Html::hiddenInput('total_comments',$total_comments, ['id' => 'hi_total_comments_' . $thread_id]) ?>

        <div class="col-xs-12 comment-tab section" id= <?="home_comment_section_" . $thread_id?>>

            <?= $this->render('../thread/_comment_part', ['comment_providers' => $comment_providers]) ?>

        </div>
<?php

    }
Pjax::end();
?>
