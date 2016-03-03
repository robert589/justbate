<?php
use kartik\tabs\TabsX;
use yii\widgets\ListView;

$content_comment = array();

$first = 1;
foreach($comment_providers as $thread_choice_item => $comment_provider){
    $content_comment_item['label'] = $thread_choice_item;
    $content_comment_item['content'] =  ListView::widget([
        'dataProvider' => $comment_provider,
        'summary' => false,
        'itemOptions' => ['class' => 'item'],
        'layout' => "{summary}\n{items}\n{pager}",
        'itemView' => function ($model, $key, $index, $widget) {
            $childCommentForm = new \frontend\models\ChildCommentForm();
            $comment_vote_comment = \common\models\CommentVote::getCommentVotesOfComment($model['comment_id'], Yii::$app->getUser()->getId());
            return $this->render('_listview_comment',['model' => $model, 'child_comment_form' => $childCommentForm,
            'total_like' => $comment_vote_comment['total_like'], 'total_dislike' => $comment_vote_comment['total_dislike'],
            'vote' => $comment_vote_comment['vote']]);
        }
    ]);
    if ($first == 1) {
        $content_comment_item['active'] = true;
        $first = 0;
    } else{
        $content_comment_item['active'] = false;
    }
    $content_comment[] = $content_comment_item;
}
?>


<?= // Ajax Tabs Above
TabsX::widget([
    'items'=>$content_comment,
    'position'=>TabsX::POS_ABOVE,
    'encodeLabels'=>false
    ])
?>
