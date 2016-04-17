<?php foreach($thread_issues as $issue){ ?>
    <span style="padding-top: 15px !important;">
        <button id="issue-button" class="btn btn-default"><strong><?= $issue['issue_name'] . ' ' ?></strong></button>
    </span>
<?php } ?>
