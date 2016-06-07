<?php

namespace backend\creator;

use yii\base\Exception;

use backend\entity\ThreadEntity;

use common\models\Thread;

class ThreadCreator implements CreatorInterface
{
    const NEED_THREAD_INFO  = 1;

    /**
     * @var ThreadEntity
     */
    public $thread;

    /**
     * ThreadCreator constructor.
     * @param ThreadEntity $thread
     */
    function __construct(ThreadEntity $thread)
    {
        $this->thread = $thread;

        //checking whether the model can be used
        $this->validateModel();
    }

    function __destruct()
    {

    }

    function validateModel()
    {
        //id must not empty
        if(is_nan($this->thread->getThreadId())){
            throw new Exception("Thread id must not be empty");
        }
    }

    public function get(array $needs)
    {
        foreach($need in $needs)
        {
            switch($need)
            {
                case self::NEED_THREAD_INFO:
                    $this->getThreadInfo();
                    break;

                default:
                    break;
            }
        }

        return $this->thread;
    }

    private function getThreadInfo()
    {
        $thread_info = \common\models\Thread::retrieveThreadById(
                            $this->thread->getThreadId(),
                            $this->thread->getCurrentUserLoginId()
                        );
        // mapping
        $this->thread->setTitle(($thread_info['title']));
        $this->thread->setDescription(($thread_info['description']));
        $this->thread->setThreadCreatorUserId(($thread_info['user_id']));
        $this->thread->setCreatedAt(($thread_info['created_at']));
        $this->thread->setUpdatedAt($thread_info['updated_at']);
        $this->thread->setThreadStatus($thread_info['thread_status']);
    }

}

?>
