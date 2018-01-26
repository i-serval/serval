<?php

namespace common\models\serval\helper;

use DateTime;

class DateTimeHelper
{

    const STAMP_FORMAT = 'Y-m-d H:i:s';

    public static function getMysqlTimestamp($stamp)
    {

        if (is_object($stamp)) {

            return $stamp->format(self::STAMP_FORMAT);

        } else {

            return (new DateTime($stamp))->format(self::STAMP_FORMAT);

        }

        return null;

    }

    public static function comapre( $first_date_time, $second_date_time )
    {

        $first_date_time = self::convertToUnixTimesamp($first_date_time);
        $second_date_time = self::convertToUnixTimesamp($second_date_time);

        return $first_date_time <=> $second_date_time;   // return  -1 0 1

    }

    protected static function convertToUnixTimesamp( $date_time )
    {

        if (is_object($date_time)) {

            return  $date_time->getTimestamp();

        } else {

            return ( new DateTime($date_time))->getTimestamp();

        }

    }

}
