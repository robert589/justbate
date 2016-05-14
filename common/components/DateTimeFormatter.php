<?php
namespace common\components;


class DateTimeFormatter{

    public static function getTimeByTimestampAndOffset($timestamp){
        $original       = new \DateTime(date("Y-m-d H:i:s", $timestamp));

        if(isset($_COOKIE['tzo'])){

            $timezoneName = timezone_name_from_abbr("", $_COOKIE['tzo']*60, false);
        }
        else{

            $timezoneName = timezone_name_from_abbr("", 8*3600, false);
        }
        return $original->setTimezone(new \DateTimezone($timezoneName))->format("Y-m-d H:i");

    }
}

?>