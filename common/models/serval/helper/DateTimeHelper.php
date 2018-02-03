<?php

namespace common\models\serval\helper;

use DateTime;
use Yii;

class DateTimeHelper
{

    const UTC_STAMP_FORMAT = 'Y-m-d H:i:s';

    public static function getMysqlTimestamp($stamp = null)
    {

        if (is_object($stamp)) {

            return $stamp->format(self::UTC_STAMP_FORMAT);

        }

        if ($stamp == null || $stamp == 0 || $stamp == false || $stamp == '') {
            return null;
        }

        return (new DateTime($stamp))->format(self::UTC_STAMP_FORMAT);

    }

    public static function getCurrentMysqlTimestamp($stamp = null)
    {

        return (new DateTime($stamp))->format(self::UTC_STAMP_FORMAT);

    }

    public static function comapre($first_date_time, $second_date_time)
    {

        $first_date_time = self::convertToUnixTimesamp($first_date_time);
        $second_date_time = self::convertToUnixTimesamp($second_date_time);

        return $first_date_time <=> $second_date_time;   // return  -1 0 1

    }

    protected static function convertToUnixTimesamp($date_time)
    {

        if (is_object($date_time)) {

            return $date_time->getTimestamp();

        } else {

            return (new DateTime($date_time))->getTimestamp();

        }

    }

    public static function convertToUTC($date_time)
    {
        if( $date_time == null ){
            return null;
        }

        if (is_object($date_time)) {

            return $date_time->format(self::UTC_STAMP_FORMAT);

        } else {

            return (new DateTime($date_time))->format(self::UTC_STAMP_FORMAT);

        }

    }

    public static function convertPHPToMomentFormat($format)
    {

        if (strncmp($format, 'php:', 4) === 0) {

            $format = substr($format, 4);

        }

        $replacements = [
            'd' => 'DD',
            'D' => 'ddd',
            'j' => 'D',
            'l' => 'dddd',
            'N' => 'E',
            'S' => 'o',
            'w' => 'e',
            'z' => 'DDD',
            'W' => 'W',
            'F' => 'MMMM',
            'm' => 'MM',
            'M' => 'MMM',
            'n' => 'M',
            't' => '', // no equivalent
            'L' => '', // no equivalent
            'o' => 'YYYY',
            'Y' => 'YYYY',
            'y' => 'YY',
            'a' => 'a',
            'A' => 'A',
            'B' => '', // no equivalent
            'g' => 'h',
            'G' => 'H',
            'h' => 'hh',
            'H' => 'HH',
            'i' => 'mm',
            's' => 'ss',
            'u' => 'SSS',
            'e' => 'zz', // deprecated since version 1.6.0 of moment.js
            'I' => '', // no equivalent
            'O' => '', // no equivalent
            'P' => '', // no equivalent
            'T' => '', // no equivalent
            'Z' => '', // no equivalent
            'c' => '', // no equivalent
            'r' => '', // no equivalent
            'U' => 'X',
        ];

        return strtr($format, $replacements);

    }

    public static function modifyFormat($format, $replacements = [])
    {

        return strtr($format, $replacements);

    }

    public static function getDatetimeWithoutSeconds($date_time, $not_set_value = '-')
    {

        if ($date_time != null) {

            return Yii::$app->formatter->asDatetime($date_time, DateTimeHelper::modifyFormat(Yii::$app->formatter->datetimeFormat, [':s' => '']));

        }

        return $not_set_value;

    }

    public static function getTimeFormatWithoutSeconds()
    {

        return DateTimeHelper::modifyFormat(Yii::$app->formatter->timeFormat, [':s' => '']);

    }

}
