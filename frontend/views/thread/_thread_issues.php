<?php
    /** @var $thread \common\entity\ThreadEntity */
    $link_to_thread = $thread->getThreadLink();
    $thread_issues = $thread->getThreadIssues();
?>

<div class="col-xs-10">

    <span id="thread-issue-text">
        <?php foreach($thread_issues as $issue){ ?>
            <span style="padding-top: 15px !important;">
              <?= \yii\helpers\Html::a('<span>' . $issue['issue_name'] . '</span>', Yii::$app->request->baseUrl . '/issue/' . $issue['issue_name']) ?>
            </span>
        <?php } ?>
    </span>

</div>
<div class="col-xs-2" style="font-size: 12pt; text-align: right;">
    <div class="fb-share-button" data-href="<?= $link_to_thread ?>" data-layout="button_count">
    </div>
</div>

