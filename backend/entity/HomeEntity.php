<?php

namespace backend\entity;

class HomeEntity implements Entity
{
    /**
     * required
     * @type integer
     * @var
     */
    protected $current_user_login_id;

    /**
     * @var string | null
     */
    private $welcome;

    /**
     * @var string | null
     */
    private $desc;

    /**
     * HomeEntity constructor.
     * @param $id
     */
    function __construct($current_user_login_id)
    {
        $this->current_user_login_id = $current_user_login_id;
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }

    /**
     * @return mixed
     */
    public function getCurrentUserLoginId()
    {
        return $this->current_user_login_id;
    }

    /**
     * @param mixed $current_user_login_id
     */
    public function setCurrentUserLoginId($current_user_login_id)
    {
        $this->current_user_login_id = $current_user_login_id;
    }

    public function setWelcome($welcome)
    {
        $this->welcome = $welcome;
    }

    public function setDesc($desc)
    {
        $this->desc = $desc;
    }

    public function getWelcome()
    {
        return $this->welcome;
    }

    public function getDesc()
    {
        return $this->desc;
    }

}
?>
