<?php

    $server = \Ratchet\Server\IoServer::factory(
        new \Ratchet\Http\HttpServer(
            new \Ratchet\WebSocket\WsServer(
                new \common\components\ChildCommentPusher()
            )
        ), 8080
    );

    $server->run();

?>