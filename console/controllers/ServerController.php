<?php
namespace console\controllers;

use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class ServerController extends \yii\console\Controller
{

    public function actionStart(){
        echo 'starting server';
        $server = \Ratchet\Server\IoServer::factory(
                new HttpServer(
                    new WsServer(
                        new \common\components\ChildCommentPusher()

                    )
                ), 8080
        );
        echo 'running server';

        $server->run();

    }
}

?>