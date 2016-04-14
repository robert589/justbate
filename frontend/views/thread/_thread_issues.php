<?php
    /** @var $thread_issues array */

?>


    <?php

        foreach($thread_issues as $issue){
    ?>
            <div style="padding:3px;display:inline-block;background-color:cornflowerblue;min-height: 8px;color: white;
            ">

                <b>
                    <?= $issue['issue_name'] . ' ' ?>
                </b>
            </div>
    <?php
        }
    ?>


