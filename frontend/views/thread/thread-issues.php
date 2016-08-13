<?php
    use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
    /** @var $thread \frontend\vo\ThreadVo */
    $thread_issues = $thread->getThreadIssues();
    $belongs = $thread->belongToCurrentUser();
    
    $first = true;
?>
<div class="thread-issues-header">
    <div class="thread-issues-container">
        <?php foreach($thread_issues as $issue){ ?>
            <?php
            if(!$first){
                echo '-';
            }else{
                $first = false;
            }
            ?>
            <span style="padding-top: 15px !important;">
              <?= \yii\helpers\Html::a('<span>' . HTMLPurifier::process($issue) . '</span>', Yii::$app->request->baseUrl . '/issue/' . HTMLPurifier::process($issue)) ?>
            </span>
        <?php } ?>
    </div>
    

</div>

