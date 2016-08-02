<?php
    use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
    /** @var $thread \frontend\vo\ThreadVo */
    $link_to_thread = $thread->getThreadLink();
    $thread_issues = $thread->getThreadIssues();
    $belongs = $thread->belongToCurrentUser();
    
    $first = true;
?>
<div class="col-xs-9" style="padding-left: 0">

    <span id="thread-issue-text">
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

    </span>

</div>
<div class="col-xs-3" style="font-size: 12pt; text-align: center;">
    <div class="fb-share-button" data-href="<?= $link_to_thread ?>" data-layout="button_count">
    </div>
</div>

