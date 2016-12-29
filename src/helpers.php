<?php
/*
 * This file is part of the Monolog package.
 *
 * (c) Tahiri Abdelkhalek <tahiri.abdou@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * this is a suit of some logger helpers functions
 * @author Tahiri Abdelkhalek <tahiri.abdou@outlook.com>
 */


// define('LOG_PATH', __DIR__. '/tests');
// define('DIRECTORY_SEPARATOR', '/');
// define('LOGGER_MODE', 'console');
define('LOGGER_DUMP_IFNOT_CONSOLE', true);

if (!function_exists('logger')) {
    function logger()
    {
        $logger = \Logger\Logger::getInstance(defined('LOGGER_MODE') ? LOGGER_MODE : 'console');
        return $logger;
    }
}

if (!function_exists('debug')) {
    
    /**
     * debug message helper
     * @param  mixed $message
     * @param  array  $context
     * @return void
     */
    function debug($message, $context = array())
    {
        $logger = logger();
        $logger->debug($message, $context);
    }
}


if (!function_exists('info')) {

    /**
     * info message helper
     * @param  mixed $message
     * @param  array  $context
     * @return void
     */
    function info($message, $context = array())
    {
        $logger = logger();
        $logger->info($message, $context);
    }
}


if (!function_exists('alert')) {

    /**
     * alert message helper
     * @param  mixed $message
     * @param  array  $context
     * @return void
     */
    function alert($message, $context = array())
    {
        $logger = logger();
        $logger->alert($message, $context);
    }
}


if (!function_exists('error')) {

    /**
     * error message helper
     * @param  mixed $message
     * @param  array  $context
     * @return void
     */
    function error($message, $context = array())
    {
        $logger = logger();
        $logger->error($message, $context);
    }
}


if (!function_exists('emergcency')) {

    /**
     * emergcency message helper
     * @param  mixed $message
     * @param  array  $context
     * @return void
     */
    function emergcency($message, $context = array())
    {
        $logger = logger();
        $logger->emergcency($message, $context);
    }
}


if (!function_exists('critical')) {

    /**
     * critical message helper
     * @param  mixed $message
     * @param  array  $context
     * @return void
     */
    function critical($message, $context = array())
    {
        $logger = logger();
        $logger->critical($message, $context);
    }
}


if (!function_exists('notice')) {

    /**
     * notice message helper
     * @param  mixed $message
     * @param  array  $context
     * @return void
     */
    function notice($message, $context = array())
    {
        $logger = logger();
        $logger->notice($message, $context);
    }
}


if (!function_exists('log')) {

    /**
     * log message helper
     * @param  string $level
     * @param  mixed $message
     * @param  array  $context
     * @return void
     */
    function log($level, $message, $context = array())
    {
        $logger = logger();
        $logger->log($level, $message, $context);
    }
}
