<?php
namespace common\components;
use common\creator\ChildCommentCreator;
use common\creator\CreatorFactory;
use common\entity\ChildCommentEntity;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use Yii;
class ChildCommentPusher implements MessageComponentInterface {
    protected $clients;
    private $subscriptions;
    private $users;

    public function __construct(){
        $this->clients = new \SplObjectStorage();
        $this->subscriptions = array();
        $this->users = array();
    }

    function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);

    }

    function onClose(ConnectionInterface $conn)
    {

        $this->clients->detach($conn);

        unset($this->users[$conn->resourceId]);
        unset($this->subscriptions[$conn->resourceId]);
        $conn->close();

    }

    function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }

    function onMessage(ConnectionInterface $conn, $msg)
    {
        $data   = json_decode($msg);

        if($data->command === "subscribe"){
            $this->subscriptions[$conn->resourceId] = $data->channel;
         }
        else if($data->command === "message"){
            echo "Tring to send data";

            $entity = new ChildCommentEntity($data->comment_id, $data->user_id);

            $creator = (new CreatorFactory())->getCreator(CreatorFactory::CHILD_COMMENT_CREATOR, $entity);
            $entity = $creator->get([
                                        ChildCommentCreator::NEED_COMMENT_INFO,
                                        ChildCommentCreator::NEED_COMMENT_VOTE
                                    ]);

            foreach($this->clients as $client){
                $client->send(json_encode($entity->jsonSerialize()));
            }
        }
    }



}