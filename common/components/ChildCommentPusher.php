<?php
namespace common\components;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use Ratchet\Wamp\WampServerInterface;

class ChildCommentPusher implements MessageComponentInterface {
    protected $clients = array();

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
    }

    function onError(ConnectionInterface $conn, \Exception $e)
    {
        // TODO: Implement onError() method.
        $conn->close();
    }

    function onMessage(ConnectionInterface $from, $msg)
    {
        // TODO: Implement onMessage() method.

        // TODO: Implement onClose() method.
        $numRecv = count($this->clients) - 1;

        foreach($this->clients as $client){
            if($from !== $client){
                $client->send($msg);
            }
        }
    }



}