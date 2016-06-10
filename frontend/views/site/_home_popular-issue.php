<?php
/** @var $popular_issue_list array */
$first = true;
?>

<div class="col-xs-12" style="margin-bottom: 15px;margin-left: 3px;">
    <div style="background-color: white;margin-top: 0">
        <h4 align="center">Popular issue</h4>
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
