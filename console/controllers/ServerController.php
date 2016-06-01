<?php
namespace console\controllers;

use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class ServerController extends \yii\console\Controller
{

    public function actionStart(){
        $server = \Ratchet\Server\IoServer::factory(
                new HttpServer(
                    new WsServer(
                        new \common\components\ChildCommentPusher()

                    )
                ), 8080

        );

        $server->run();

    }
}

?>