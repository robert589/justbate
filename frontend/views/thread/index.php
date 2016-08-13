<?php
use yii\widgets\ListView;
use yii\helpers\Html;
use kartik\tabs\TabsX;
use kartik\dialog\Dialog;
use yii\widgets\ActiveForm;
use yii\helpers\HtmlPurifier;
use frontend\widgets\ThreadSectionBottom;
/** @var $thread \frontend\vo\ThreadVo */
/** @var $comment_model \frontend\models\CommentForm */
/** @var $submit_vote_form \frontend\models\SubmitThreadVoteForm */

//variable used in this page
$this->title =  $thread->getTitle();
$thread_choices = $thread->getMappedChoices();
$comment_providers = $thread->getThreadCommentList();
$content_comment = array();
$current_user_choice = $thread->getCurrentUserVote();
$choices_in_thread = $thread->getChoices();
$thread_id = $thread->getThreadId();

$guest = $thread->isGuest();
$propered_choice_text = array();
foreach($thread_choices as $item){
    $item_values = array_values($item);
    $propered_choice_text[$item_values[0]]  = HTMLPurifier::process($item_values[0] . " (" . $item['total_voters'] . ")");
}
$first = 1;
foreach($comment_providers as $thread_choice_item => $comment_provider){
    $content_comment_item['label'] = Html::encode($thread_choice_item);
    $content_comment_item['content'] =  ListView::widget([
        'dataProvider' => $comment_provider,
        'summary' => false,
        'itemOptions' => ['class' => 'thread-comment'],
        'layout' => "{summary}\n{items}\n{pager}",
        'itemView' => function ($thread_comment, $key, $index, $widget) {
            return $this->render('../comment/thread-comment'	,
                                ['thread_comment' => $thread_comment,
                                 'child_comment_form' => new \frontend\models\ChildCommentForm()]);
        }
    ]);

    if($first == 1){
            $content_comment_item['active'] = true;
            $first = 0;
    }
    else{
            $content_comment_item['active'] = false;
    }

    $content_comment[] = $content_comment_item;
}

//start of html
?>

<?= Dialog::widget(); ?>

<div class="col-xs-12 col-md-6 thread-main-body">
    <?= $this->render('thread-section',
            ['thread' => $thread ,
             'edit_thread_form' => new \frontend\models\EditThreadForm(),
             'submit_vote_form' => $submit_vote_form]); ?>
    <?= ThreadSectionBottom::widget(['thread' => $thread, 'id' => 'thread-section-bottom-' . $thread_id]) ?>
    
    <div id="comment-tab">
            <?= // Ajax Tabs Above
            TabsX::widget([
                    'id' => 'comment-tab',
                    'items'=>$content_comment,
                    'position'=>TabsX::POS_ABOVE,
                    'encodeLabels'=>false,
                    'enableStickyTabs' => true
            ])
            ?>
    </div>
</div>
<?php $form = ActiveForm::begin(['action' => ['delete-thread'], 'method' => 'post', 'id' => 'delete_thread_form']) ?>
    <?= Html::hiddenInput('thread_id', $thread_id) ?>
<?php ActiveForm::end() ?>
