<?php
/*
 * This file is part of the Monolog package.
 *
 * (c) Tahiri Abdelkhalek <tahiri.abdou@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Logger;

use Psr\Log\LogLevel as PsrLogLevel;

/**
 * Describes log levels.
 *
 * @author Tahiri Abdelkhalek <tahiri.abdou@outlook.com>
 */
class LogLevel extends PsrLogLevel
{
    /**
     * Log levels ranking
     * @var array
     */
    private static $_levels = [
        self::DEBUG     => 7,
        self::INFO      => 6,
        self::NOTICE    => 5,
        self::WARNING   => 4,
        self::ERROR     => 3,
        self::CRITICAL  => 2,
        self::ALERT     => 1,
        self::EMERGENCY => 0,
    ];

    /**
     * get Level ranking
     * @param  string $level debug level
     * @return integer debug level value
     */
    public static function getLevel($level)
    {
        if (isset(self::$_levels[$level])) {
            return self::$_levels[$level];
        }
        return false;
    }
}
