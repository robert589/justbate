<?php
namespace common\components;
use common\entity\ChildCommentEntity;
use common\models\User;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use Ratchet\Wamp\WampServerInterface;

class ChildCommentPusher implements MessageComponentInterface {
    protected $clients;
    private $subscriptions;
    private $users;

    public function __construct(){
        $this->clients = new \SplObjectStorage();
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
    }

    function onError(ConnectionInterface $conn, \Exception $e)
    {
        // TODO: Implement onError() method.
        $conn->close();
    }

    function onMessage(ConnectionInterface $conn, $msg)
    {
        // TODO: Implement onMessage() method.
        $data   = json_decode($msg);
        if($data->command === "subscribe"){
            $this->subscriptions[$conn->resourceId] = $data->channel;
         }
        else if($data->command === "message"){
            if(isset($this->subscriptions[$conn->resourceId])){
                $target = $this->subscriptions[$conn->resourceId];
                foreach($this->subscriptions as $id => $channel){
                    if ($channel == $target && $id != $conn->resourceId) {
                        $user_id = $data->user_id;


                        $this->users[$id]->send($data->message);
                    }
                }
            }
        }
    }



}