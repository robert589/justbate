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

    public static function getTimeText($unix_timestamp) {
        $etime = time() - $unix_timestamp;

        if ($etime < 1)
        {
            return '0 seconds';
        }

        $a = array( 365 * 24 * 60 * 60  =>  'year',
            30 * 24 * 60 * 60  =>  'month',
            24 * 60 * 60  =>  'day',
            60 * 60  =>  'hour',
            60  =>  'minute',
            1  =>  'second'
        );
        $a_plural = array( 'year'   => 'years',
            'month'  => 'months',
            'day'    => 'days',
            'hour'   => 'hours',
            'minute' => 'minutes',
            'second' => 'seconds'
        );

        foreach ($a as $secs => $str)
        {
            $d = $etime / $secs;
            if ($d >= 1)
            {
                $r = round($d);
                return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
            }
        }

    }
}

?>
