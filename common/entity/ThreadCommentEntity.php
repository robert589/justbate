<?php

namespace common\entity;

use yii\data\ArrayDataProvider;

class ThreadCommentEntity extends CommentEntity{

    /**
     * required
     * @var integer
     */
    private $thread_id;

    /**
     * @type array
     * @var
     */
    private $choice_text;

    /**
     * @var ArrayDataProvider
     */
    private $child_comment_list;

    /**
     * Thread constructor.
     * @param $id
     */
    function __construct($comment_id, $current_user_login_id){
        parent::__construct($comment_id, $current_user_login_id);
    }


    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }

    /**
     * @return int
     */
    public function getThreadId()
    {
        return $this->thread_id;
    }

    /**
     * @param int $thread_id
     */
    public function setThreadId($thread_id)
    {
        $this->thread_id = $thread_id;
    }

    /**
     * @return mixed
     */
    public function getCommentatorChoice()
    {
        return $this->choice_text;
    }

    /**
     * @param mixed $choices
     */
    public function setCommentatorChoice($choice_text)
    {
        $this->choice_text = $choice_text;
    }


    public function setDataFromArray(array  $array){
        parent::setDataFromArray($array);

        $this->choice_text = isset($array['choice_text']) ? $array['choice_text'] : null;
        $this->thread_id = isset($array['thread_id']) ? $array['thread_id'] : null;

    }


    public function getChildCommentRequestURL(){
        return \Yii::$app->request->baseUrl . '/thread/get-child-comment?thread_id=' . $this->thread_id . '&comment_id=' . $this->comment_id ;
    }

    /**
     * @return ArrayDataProvider
     */
    public function getChildCommentList()
    {
        return $this->child_comment_list;
    }

    /**
     * @param ArrayDataProvider $child_comment_list
     */
    public function setChildCommentList($child_comment_list)
    {
        $this->child_comment_list = $child_comment_list;
    }



    public function getChildCommentConnection(){
        return \Yii::$app->request->baseUrl . '/thread/get-child-comment-socket';
    }

}