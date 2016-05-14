<?php
use kartik\tabs\TabsX;
use yii\widgets\ListView;
use yii\helpers\Html;
/** @var  $comment_providers \yii\data\ArrayDataProvider */
$content_comment = array();

$first = 1;
foreach($comment_providers as $thread_choice_item => $comment_provider){
    $content_comment_item['label'] = Html::encode($thread_choice_item);
    $content_comment_item['content'] =  ListView::widget([
        'dataProvider' => $comment_provider,
        'summary' => false,
        'itemOptions' => ['class' => 'item'],
        'layout' => "{summary}\n{items}\n{pager}",
        'itemView' => function ($model, $key, $index, $widget) {
            $childCommentForm = new \frontend\models\ChildCommentForm();

            return $this->render('_listview_comment',['model' => $model,
                                                      'child_comment_form' => $childCommentForm
                                                     ]);
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
