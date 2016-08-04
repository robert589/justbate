<?php
namespace common\libraries;

use common\components\Constant;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Utility {
       
    public static function cutText($text, $cut_point) {
        $length_of_string = strlen($text);
        $text = Constant::removeAllHtmlTag($text);
        if($length_of_string <= $cut_point) {
            return $text;
        }
        $text = substr($text, 0 , $cut_point);
        return $text;
    }
    
}