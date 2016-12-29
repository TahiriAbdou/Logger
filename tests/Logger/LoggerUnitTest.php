<?php
/*
 * This file is part of the Monolog package.
 *
 * (c) Tahiri Abdelkhalek <tahiri.abdou@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Test\Logger;

use Psr\Log\NullLogger;
use Logger\Logger;
use Logger\LogLevel;

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
        $this->assertInstanceOf('Logger\Logger', $mockInstance);
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
    // public function testFileMessageWrite()
    // {
    //     define('LOG_PATH', getenv('LOG_PATH'));
    //     $filename = getenv('ROOT_PATH').'/'.getenv('LOG_FILE');

    //     $mockInstance = new Logger('file');
    //     $message = "Hello darkness my old friend";

    //     $mockInstance->info($message);

    //     $fileContent = FileSystem::read($filename);
    //     $this->assertContains($message, $fileContent);
    // }

}
