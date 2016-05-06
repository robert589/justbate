<span id="thread-issue-text">
    <?php foreach($thread_issues as $issue){ ?>
        <span>Topic :: </span><span><?= $issue['issue_name'] . ' ' ?></span>
        <?php } ?>
    </span>
