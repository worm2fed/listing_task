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
     * @param string $dateFormat, default is 'Y-m-d'
     * @param string $timeFormat, default is ''H:m:s'
     * 
     * @return array with formatted [date, time] 
     * or returns singleton array ['not set'] if $timestamp is null 
     * or returns singleton array ['not valid'] if $timestamp is not valid 
     */
    public static function formatTimestamp(
        $timestamp,
        string $dateFormat = 'Y-m-d',
        string $timeFormat = 'H:m:s'
    ): array {
        if ($timestamp === null) {
            return [Yii::t('app/error', 'datetime.not_set')];
        } elseif (!self::isValidTimestamp($timestamp)) {
            return [Yii::t('app/error', 'datetime.not_valid')];
        }

        $dt = new DateTime();
        $dt->setTimestamp($timestamp);

        return [$dt->format($dateFormat), $dt->format($timeFormat)];
    }
}
