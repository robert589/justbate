<?php

namespace common\creator;

use common\entity\Entity;

class CreatorFactory {

    const THREAD_CREATOR = "thread_creator";
        //use getShape method to get object of type shape
    const THREAD_COMMENT_CREATOR = "thread_comment_creator";

    const CHILD_COMMENT_CREATOR = "child_comment_creator";

    const HOME_CREATOR = "home_creator";
    /**
     * @param $creatorType string
     * @param Entity $model
     * @return ThreadCreator|null
     */
    public function getCreator($creatorType, Entity $model ){

        if($creatorType == null){
            return null;
        }
        if($creatorType === self::THREAD_CREATOR){
            return new ThreadCreator($model);
        }
        else if($creatorType === self::THREAD_COMMENT_CREATOR){
            return new ThreadCommentCreator($model);
        }
        else if($creatorType === self::CHILD_COMMENT_CREATOR){
            return new ChildCommentCreator($model);
        }
        else if($creatorType == self::HOME_CREATOR){
            return new HomeCreator($model);
        }

        return null;
    }
}