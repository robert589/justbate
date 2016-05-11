<?php
//retrieve from _list_thread_bottom

use yii\widgets\Pjax;
use yii\bootstrap\Html;
use yii\widgets\ActiveForm;

/** @var $thread_id integer */
/** @var $total_comments integer */
/** @var $comment_providers \yii\data\ArrayDataProvider */
/** @var $comment_retrieved boolean */
Pjax::begin([
    'id' => 'comment_section_' . $thread_id,
    'enablePushState' => false,
    'timeout' => 70000,
    'options' => [
        'class' => 'comment_section_pjax',
        'data-service' => $thread_id,
        'container' => '#comment_section_' . $thread_id
    ]
])
?>

<?php
    if(isset($comment_retrieved)){ ?>

        <?= Html::hiddenInput('total_comments',$total_comments, ['id' => 'hi_total_comments_' . $thread_id]) ?>

        <div class="col-xs-12 comment-tab section" id= <?="home_comment_section_" . $thread_id?>>
            <?= $this->render('../thread/_comment_part', ['comment_providers' => $comment_providers]) ?>
        </div>
    <?php } ?>
<?php Pjax::end(); ?>
