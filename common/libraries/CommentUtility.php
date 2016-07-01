<?php
namespace common\libraries;
use Yii;
use yii\helpers\Html;
use common\components\Constant;

class CommentUtility{

    public static function cutText($comment){
        $comment = Constant::removeAllHtmlTag($comment);
        $comment = substr($comment, 0 , 65);
        return $comment;
    }

    public static function getCommentForLink($comment){
        $comment = self::cutText($comment);

        return str_replace(' ' , '-', strtolower($comment));
    }

}