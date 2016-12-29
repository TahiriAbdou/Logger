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

use Psr\Log\NullLogger;


class LoggerUnitTest extends \PHPUnit_Framework_TestCase
{

    
    /**
     * @test
     *
     */
    public function returnLoggerInstanceSingleton()
    {
        $mode = 'file';
        $mockInstance = Logger::getInstance($mode);
        $this->assertInstanceOf(Logger::class, $mockInstance);
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function throwsExceptionWhenDebugModeIsNotAvailable()
    {
        $mockInstance = new Logger('console');
        $mockInstance->setMode('slack');
    }

    /**
     * @test
     */
    public function testGetLevelLog()
    {
        $this->assertEquals('debug',LogLevel::DEBUG);
        $this->assertEquals('info',LogLevel::INFO);
        $this->assertEquals('notice',LogLevel::NOTICE);
        $this->assertEquals('warning',LogLevel::WARNING);
        $this->assertEquals('error',LogLevel::ERROR);
        $this->assertEquals('critical',LogLevel::CRITICAL);
        $this->assertEquals('alert',LogLevel::ALERT);
        $this->assertEquals('emergency',LogLevel::EMERGENCY);
    }

    /**
     * @test
     * 
     */
    public function testFileMessageWrite()
    {
        define('LOGGER_LOG_FILENAME', 'unit_test_logfile');
        define('LOG_PATH', __DIR__. '/../../tests');
        define('DIRECTORY_SEPARATOR', '/');
        $filename = LOG_PATH . DIRECTORY_SEPARATOR . LOGGER_LOG_FILENAME . '.log';

        $mockInstance = new Logger('file');
        $message = "Hello darkness my old friend";

        $mockInstance->info($message);

        $fileContent = file_get_contents($filename);
        $this->assertContains($message, $fileContent);
    }

}
