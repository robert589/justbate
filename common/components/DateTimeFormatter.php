<?php
namespace common\components;


/**
 * Class DateTimeFormatter
 * @package common\components
 */
class DateTimeFormatter{

    const DEFAULT_DATE_FORMAT = "Y-m-d H:i:s";

    const DEFAULT_TIMEZONE_OFFSET = 8;

    /**
     * @param $timestamp
     * @return string
     */
    public static function getTimeByTimestampAndTimezoneOffset($timestamp){
        $original       = new \DateTime(date(self::DEFAULT_DATE_FORMAT, $timestamp));

        if(isset($_COOKIE['tzo'])){
            $timezoneName = timezone_name_from_abbr("", $_COOKIE['tzo']*60, false);
        }
        else{
            $timezoneName = timezone_name_from_abbr("", self::DEFAULT_TIMEZONE_OFFSET*3600, false);
        }

        return $original->setTimezone(new \DateTimezone($timezoneName))->format(self::DEFAULT_DATE_FORMAT);

    }
}

?>