<?php

namespace backend\creator;

use yii\base\Exception;

use backend\entity\UserEntity;

class UserCreator implements CreatorInterface
{
    public $user;

    function __construct(UserEntity $user)
    {
        $this->user = $user;
    }

    public function get(array $needs)
    {
        return $this->user;
    }

    public static function getAllUsers()
    {
        
    }
}

 ?>
