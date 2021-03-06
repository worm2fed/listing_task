<?php

namespace app\components;

use DateTime;
use Yii;

/**
 * This class provides different tools to work with date and time
 */
class DateTimeTools
{
    /**
     * Checks whether provided timestamp is valid
     * 
     * @param $timestamp
     * 
     * @return bool
     */
    public static function isValidTimestamp($timestamp): bool
    {
        return (string) (int) $timestamp === (string) $timestamp
            && $timestamp <= PHP_INT_MAX
            && $timestamp >= ~PHP_INT_MAX;
    }

    /**
     * Formats timestamp to tuple according to provided format
     * 
     * @param $timestamp
     * @param string $asArray, default is true, whether return array or string
     * @param string $dateFormat, default is 'Y-m-d'
     * @param string $timeFormat, default is 'H:m:s'
     * 
     * @return array|string with formatted [date, time] (or 'date time')
     *     or returns ['not set'] if $timestamp is null (or 'not set')
     *     or returns ['not valid'] if $timestamp is not valid (or 'not valid') 
     */
    public static function formatTimestamp(
        $timestamp,
        bool $asArray = true,
        string $dateFormat = 'Y-m-d',
        string $timeFormat = 'H:m:s'
    ) {
        $result = [Yii::t('app/error', 'datetime.not_set')];
        if (!self::isValidTimestamp($timestamp)) {
            $result = [Yii::t('app/error', 'datetime.not_valid')];
        } else {
            $dt = new DateTime();
            $dt->setTimestamp($timestamp);
            $result = [$dt->format($dateFormat), $dt->format($timeFormat)];
        }

        if ($asArray) {
            return $result;
        }
        return implode(' ', $result);
    }
}
