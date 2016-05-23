<span id="thread-issue-text">
    <?php foreach($thread_issues as $issue){ ?>
        <span style="padding-top: 15px !important;">
          <?= \yii\helpers\Html::a('<span>' . $issue['issue_name'] . '</span>', Yii::$app->request->baseUrl . '/issue/' . $issue['issue_name']) ?>
        </span>
    <?php } ?>
</span>
