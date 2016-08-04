<?php
namespace common\libraries;
use Yii;
use yii\helpers\Html;
use common\components\Constant;

class CommentUtility{

    public static function cutText($comment, $count = 30){
        $length_of_string = strlen($comment);
        $comment = Constant::removeAllHtmlTag($comment);


        if($length_of_string <= $count) {
            return $comment;
        }
        $comment = substr($comment, 0 , $count);
        return $comment . '. . .';
    }

    public static function getCommentForLink($comment){
        $comment = self::cutText($comment);

        return str_replace(' ' , '-', strtolower($comment));
    }

}