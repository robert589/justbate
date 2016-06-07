<?php

namespace backend\creator;

use backend\entity\Entity;

class CreatorFactory
{
    const THREAD_CREATOR = "thread_creator";
    const HOME_CREATOR = "home_creator";

    /**
     * @param $creatorType string
     * @param Entity $model
     * @return ThreadCreator|null
     */
    public function getCreator($creatorType, Entity $model)
    {
        if($creatorType == null)
        {
            return null;
        }
        if($creatorType === self::THREAD_CREATOR)
        {
            return new ThreadCreator($model);
        }
        if($creatorType == self::HOME_CREATOR)
        {
            return new HomeCreator($model);
        }
    }
}

?>
