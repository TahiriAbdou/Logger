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

use Psr\Log\LoggerInterface;

/**
 * Logger class
 *
 * It contains a simple implementation of PSR-3 LoggerInterface
 *
 * @author Tahiri Abdelkhalek <tahiri.abdou@outlook.com>
 */
class Logger implements LoggerInterface
{
    /**
     * available debug modes
     * @var array
     */
    private $modes = [
        'console',
        'file'
    ];

    /**
     * current debug mode
     * @var string
     */
    private $mode;

    /**
     * value of log level
     * @var integer
     */
    private $threshold;

    /**
     * the output stream string
     * @var string
     */
    private $output;

    /**
     * Singleton class instance
     * @var Logger
     */
    private static $instance;

    /**
     * display called name and line of log called , not required but usefull
     * @var boolean
     */
    private $debugtrack = true;

    /**
     * Logger constructor
     * @param string  $mode      debug mode
     * @param integer  $threshold debug level
     */
    public function __construct($mode, $threshold = 0)
    {
        $this->setMode($mode);
        $this->setThreshold($threshold);
    }

    /**
     * get a singleton of Logger class
     * @param string  $mode  debug mode
     * @return Logger
     */
    public static function getInstance($mode='console')
    {
        if (!isset(self::$instance)) {
            self::$instance = new self($mode);
        }
        return self::$instance;
    }

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function emergency($message, array $context = array())
    {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function alert($message, array $context = array())
    {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function critical($message, array $context = array())
    {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function error($message, array $context = array())
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function warning($message, array $context = array())
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function notice($message, array $context = array())
    {
        $this->log(LogLevel::NOTICE, $message, $context);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function info($message, array $context = array())
    {
        $this->log(LogLevel::INFO, $message, $context);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function debug($message, array $context = array())
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function log($level, $message, array $context = array())
    {
        $threshold = LogLevel::getLevel($level);

        if ($threshold===false || $threshold < $this->threshold) {
            return false;
        }

        $output  = $this->getOutput();
        $message = $this->formatMessage($level, $message, $context);
        if (!$fp = @fopen($output, 'ab')) {
            return false;
        }

        flock($fp, LOCK_EX);
        fwrite($fp, $message);
        flock($fp, LOCK_UN);
        fclose($fp);
        return true;
    }

    /**
     * Format message
     *
     * @param  string $level
     * @param  string $message
     * @param  array $message
     * @return string
     */
    public function formatMessage($level, $message, $context)
    {
        $datetime = date("Y-m-d H:i:s");
        $level = strtoupper($level);
        $eol = php_sapi_name()==='cli' ? PHP_EOL : '<br />';
        if (is_array($message) || is_object($message)) {
            $message = $eol . var_export($message, true);
        }
        $output = $datetime;
        if ($this->debugtrack) {
            $output .= ' ' . $this->getDebugfileLine();
        }
        if (!empty($context)) {
            $message .= $eol . var_export(compact('context'), true);
        }

        $output  .= sprintf(" [%s] %s %s", $level, $message, $eol);
        return $output;
    }

    /**
     * set the threshold value of log level
     *
     * @param integer $threshold
     */
    public function setThreshold($threshold)
    {
        $this->threshold = $threshold;
    }

    /**
     * set the debugtrace value
     *
     * @param boolean $debugtrace
     */
    public function setDebugTrace($debugtrace)
    {
        $this->debugtrace = $debugtrace;
    }

    /**
     * set the output mode
     *
     * @param string $mode
     * @throws Exception
     */
    public function setMode($mode)
    {
        if ($this->isInValidMode($mode)) {
            throw new \Exception('The logger mode type is error.');
        }
        $this->mode = $mode;
    }

    /**
     * return the output stream string
     *
     * @return string
     */
    private function getOutput()
    {
        if (is_null($this->output)) {
            switch ($this->mode) {
                case 'console':
                    $this->output = 'php://output';
                    break;
                case 'file':
                    $this->output = $this->getLogFile();
                    break;
            }
        }
        return $this->output;
    }

    public function getDebugfileLine()
    {
        $trace = debug_backtrace();
        $lastTrace = end($trace);

        return sprintf('%s:%s', $lastTrace['file'], $lastTrace['line']);
    }

    /**
     * return the log file name
     *
     * @return string
     */
    private function getLogName()
    {
        $ext       = '.log';
        if (defined('LOGGER_LOG_FILENAME')) {
            $file_name =  LOGGER_LOG_FILENAME . $ext;
        } else {
            $datetime  = date("Y-m-d");
            $file_name = "$datetime" . $ext;
        }
        return $file_name;
    }


    /**
     * get file name and create it if not existed
     * @return [type] [description]
     */
    public function getLogFile()
    {
        $filename = LOG_PATH . DIRECTORY_SEPARATOR . $this->getLogName();
        if (!file_exists($filename)) {
            touch($filename);
        }
        return $filename;
    }

    /**
     * check the mode is INVALID
     *
     * @param string $mode
     * @return  boolean
     */
    private function isInValidMode($mode)
    {
        return !$this->isValidMode($mode);
    }

    /**
     * check the mode is VALID
     *
     * @param string $mode
     * @return boolean
     */
    private function isValidMode($mode)
    {
        return in_array($mode, $this->modes);
    }
}
