<?php

namespace common\creator;
use common\entity\ThreadCommentEntity;
use common\entity\ThreadEntity;
use common\models\Choice;
use common\models\Comment;
use common\models\Thread;
use common\models\ThreadComment;
use common\models\ThreadIssue;
use common\models\ThreadVote;
use yii\base\Exception;

class ThreadCreator implements CreatorInterface{

    const NEED_THREAD_ISSUE  = 1;

    const NEED_THREAD_INFO  = 2;

    const NEED_CHOOSE_ONE_COMMENT = 3;

    const NEED_THREAD_CHOICE = 4;

    const NEED_THREAD_COMMENTS = 5;

    const NEED_TOTAL_COMMENTS = 6;

    const NEED_USER_CHOICE_ON_THREAD_ONLY = 7;
    /**
     * @var ThreadEntity
     */
    public $thread;

    /**
     * ThreadCreator constructor.
     */
    function __construct(ThreadEntity $thread)
    {
        $this->thread = $thread;

        //checking whether the model can be used
        $this->validateModel();
    }

    /**
     * @param array $config
     * @return ThreadEntity
     */
    public function get(array $needs){
        foreach($needs as $need){
            switch($need){
                case self::NEED_THREAD_ISSUE:
                    $this->getThreadIssue();
                    break;
                case self::NEED_THREAD_INFO:
                    $this->getThreadInfo();
                    break;
                case self::NEED_THREAD_CHOICE:
                    $this->getThreadChoice();
                    break;
                case self::NEED_CHOOSE_ONE_COMMENT:
                    $this->getOneComment();
                    break;
                case self::NEED_THREAD_COMMENTS:
                    $this->getThreadComments();
                    break;
                case self::NEED_TOTAL_COMMENTS:
                    $this->getTotalComment();
                    break;
                case self::NEED_USER_CHOICE_ON_THREAD_ONLY:
                    $this->getUserChoiceOnly();
                    break;
                default:
                    break;
            }
        }
        return $this->thread;
    }

    function validateModel(){
        //id must not empty
        if(is_nan($this->thread->getThreadId())){
            throw new Exception("Thread id must not be empty");
        }
    }

    private function getThreadIssue(){
        //thread_issue
        $this->thread->setThreadIssues(ThreadIssue::getIssue($this->thread->getThreadId()));
    }

    private function getThreadInfo(){
        $thread_info = \common\models\Thread::retrieveThreadById($this->thread->getThreadId(), $this->thread->getCurrentUserLoginId());
        //mapping
        $this->thread->setTitle(($thread_info['title']));
        $this->thread->setDescription(($thread_info['description']));
        $this->thread->setCurrentUserLoginId(($thread_info['user_id']));
        $this->thread->setDateCreated(($thread_info['created_at']));
        $this->thread->setDateUpdated($thread_info['updated_at']);
        $this->thread->setThreadStatus($thread_info['thread_status']);

    }


    private function getThreadComments()
    {

        $comment_providers = Comment::getAllCommentProviders($this->thread->getThreadId(), $this->thread->getChoices(), $this->thread->getCurrentUserLoginId());

        $this->thread->setCommentList($comment_providers);
    }


    private function getThreadChoice(){
        $this->thread->setChoices(Choice::getMappedChoiceAndItsVoters($this->thread->getThreadId()));
    }

    private function getOneComment(){
        $result = ThreadComment::getBestCommentFromThread($this->thread->getThreadId());

        if($result === false){
            return null;
        }

        $thread_comment = new ThreadCommentEntity($result['comment_id'], $this->thread->getCurrentUserLoginId());

        $thread_comment->setDataFromArray($result);

        $creator = (new CreatorFactory())->getCreator(CreatorFactory::THREAD_COMMENT_CREATOR, $thread_comment);
        $thread_comment = $creator->get([ThreadCommentCreator::NEED_COMMENT_VOTE]);

        $this->thread->setChosenComment($thread_comment);
    }

    private function getTotalComment(){
        $result = ThreadComment::getTotalThreadComments($this->thread->getThreadId());
        $this->thread->setTotalComment($result);
    }

    private  function getUserChoiceOnly(){
        $result = ThreadVote::find()
            ->where(['thread_id' => $this->thread->getThreadId()])
            ->andWhere(['user_id' => $this->thread->getCurrentUserLoginId()])
            ->one();

        if($result !== null){
            $this->thread->setCurrentUserChoice(  $result->choice_text   );
        }



    }

}