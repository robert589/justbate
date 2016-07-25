<?php

namespace backend\service;

use backend\dao\SiteDao;
use backend\dao\ThreadDao;
// use backend\dao\ThreadCommentDao;
// use backend\dao\ChildCommentDao;
// use backend\dao\IssueDao;
// use backend\dao\UserDao;

class ServiceFactory {

    const SITE_SERVICE = "site_service";

    const THREAD_SERVICE = "thread_service";

    const THREAD_COMMENT_SERVICE = "thread_comment_service";

    const CHILD_COMMENT_SERVICE = "child_comment_service";

    const ISSUE_SERVICE = "issue_service";

    const USER_SERVICE = "user_service";

    public function getService($creatorType){
        if($creatorType === self::SITE_SERVICE){
            return new SiteService(new SiteDao());
        }
        else if($creatorType === self::THREAD_SERVICE){
            return null;
        }
        else if ($creatorType === self::THREAD_COMMENT_SERVICE){
            return null;
        }
        else if ($creatorType === self::CHILD_COMMENT_SERVICE){
            return null;
        }
        else if ($creatorType === self::ISSUE_SERVICE){
            return null;
        }
        else if ($creatorType === self::USER_SERVICE){
            return null;
        }

        return null;
    }
}

 ?>
