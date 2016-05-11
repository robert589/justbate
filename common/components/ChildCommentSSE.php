<?php

namespace app\components;

class ChildCommentSSE{

    /**
     *
     * @var boolean
     */
    private $_headerSent;

    private function sendHeader(){
        if($this->_headerSent ){
            $this->_headerSent = true;
            header("Content-Type: text/event-stream");
            header('Cache-Control: no-cache');
        }


    }

    public function sendMessage($message){
        echo $message;
    }
}
?>