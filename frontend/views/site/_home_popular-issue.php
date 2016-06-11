<?php
/** @var $popular_issue_list array */
$first = true;
?>

<div class="col-xs-12" style="margin-bottom: 15px;margin-left: 3px;">
    <div style="background-color: white;padding-top:0;margin-top: 0">
        <h4 align="center" style="background-color: #F2F2F2;margin-bottom: 5px;padding: 5px;font-weight: normal;" >POPULAR ISSUE</h4>
        <ul style="display: inline;padding: 1px;">
            <?php
            foreach($popular_issue_list as $issue){
                if(!$first){echo '-';}else{ $first = false;}
            ?>
                <li style="display: inline">
                    <a href="<?= $issue['url'] ?>" style="font-size: 12px">
                        <?= $issue['label'] ?>
                    </a>
                </li>

            <?php } ?>
        </ul>
    </div>
</div>
