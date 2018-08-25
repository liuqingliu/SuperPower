<?php
/**
 * Created by PhpStorm.
 * User: 60916
 * Date: 2018/8/22
 * Time: 18:33
 */

/**
 * SnowFlake ID Generator
 * Based on Twitter Snowflake to generate unique ID across multiple
 * datacenters and databases without having duplicates.
 *
 *
 * SnowFlake Layout
 *
 * 1 sign bit -- 0 is positive, 1 is negative
 * 41 bits -- milliseconds since epoch
 * 5 bits -- dataCenter ID
 * 5 bits -- machine ID
 * 12 bits -- sequence number
 *
 * Total 64 bit integer/string
 */
namespace App\Models\Logic;

class Snowflake
{
    const workerIdBits                 = 4;
    const sequenceBits                 = 10;
    private static $workerId           = 0;
    private static $twepoch            = 1361775855078;
    private static $sequence           = 0;
    private static $workerIdShift      = 10;
    private static $timestampLeftShift = 14;
    private static $sequenceMask       = 1023;
    private static $lastTimestamp      = -1;

    private static function _getWorkerId($wordId)
    {
        self::$workerId = $wordId;
        if (self::$workerId === 0) {
            preg_match_all('/\d+/', md5(php_uname()), $arr);
            self::$workerId = implode('', $arr[0]) % 15;
        }
    }

    private static function _timeGen()
    {
        $time  = explode(' ', microtime());
        $time2 = substr($time[0], 2, 3);

        return $time[1] . $time2;
    }

    private static function _tilNextMillis($lastTimestamp)
    {
        $timestamp = self::_timeGen();
        while ($timestamp <= $lastTimestamp) {
            $timestamp = self::_timeGen();
        }

        return $timestamp;
    }
    //*id     最大值 12872564620034048    （由时间戳 strtotime('2038-01-19 03:14:07')."999"  生成 id）
    //*bigint 最大值 9223372036854775807
    public static function nextId($wordId = 0)
    {
        self::_getWorkerId($wordId);
        $timestamp = self::_timeGen();
        if (self::$lastTimestamp == $timestamp) {
            self::$sequence = (self::$sequence + 1) & self::$sequenceMask;
            if (self::$sequence == 0) {
                $timestamp = self::_tilNextMillis(self::$lastTimestamp);
            }
        } else {
            self::$sequence = 0;
        }
        if ($timestamp < self::$lastTimestamp) {
            throw new Excwption('Clock moved backwards.  Refusing to generate id for ' . (self::$lastTimestamp - $timestamp) . ' milliseconds');
        }
        self::$lastTimestamp = $timestamp;
        $nextId              = ((sprintf('%.0f', $timestamp) - sprintf('%.0f', self::$twepoch)) << self::$timestampLeftShift) | (self::$workerId << self::$workerIdShift) | self::$sequence;

        return $nextId;
    }
}