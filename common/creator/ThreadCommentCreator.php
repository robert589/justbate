<?php

namespace common\creator;
use common\entity\ChildCommentEntity;
use common\entity\CommentEntity;
use common\entity\ThreadCommentEntity;
use common\entity\ThreadEntity;
use common\models\ChildComment;
use common\models\Comment;


class ThreadCommentCreator extends CommentCreator{

    const NEED_CHILD_COMMENTS = 5;

    const NEED_COMMENT_INFO = 19;

    /**
     * ThreadCreator constructor.
     * @param ThreadCommentEntity $comment_entity
     */
    function __construct(ThreadCommentEntity $comment_entity)
    {
        parent::__construct($comment_entity);

    }

    public function get(array $needs){
        $this->comment = parent::get($needs);

        foreach($needs as $need){
            switch($need){
                case self::NEED_CHILD_COMMENTS:
                    $this->getChildComments();
                    break;
                case self::NEED_COMMENT_INFO:
                    $this->getCommentInfo();
                    break;
                default:
                    break;
            }
        }

        return $this->comment;
    }

    private function getChildComments(){

        $results =  ChildComment::getAllChildCommentsByCommentId($this->comment->getCommentId());

        $comment_entities = array();

        foreach($results as $result){
            $comment_entity = new ChildCommentEntity($this->comment->getCommentId(), $this->comment->getCurrentUserLoginId());
            $comment_entity->setDataFromArray($result);
            $creator = (new CreatorFactory())->getCreator(CreatorFactory::CHILD_COMMENT_CREATOR,$comment_entity);
            $comment_entity = $creator->get([CommentCreator::NEED_COMMENT_VOTE]);
            $comment_entities[]  = $comment_entity;
        }

        $child_comment_provider = new \yii\data\ArrayDataProvider([
            'allModels' => $comment_entities,
            'pagination' => [
                'pageSize' => 5,
            ]
        ]);

        $this->comment->setChildCommentList($child_comment_provider);
    }

    private function getCommentInfo(){
        $model = Comment::getCommentByCommentId($this->comment->getCommentId(), $this->comment->getCurrentUserLoginId());
        $this->comment->setDataFromArray($model);
    }
}