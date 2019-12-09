<?php
namespace DerekHamilton\Tests\Glove\Logging;

use DerekHamilton\Glove\Logging\Logger;
use Exception;
use Mockery;
use Psr\Log\LoggerInterface;

class LoggerTest extends \DerekHamilton\Tests\Glove\TestCase
{
    public function testLog()
    {
        $logLevel = 'critical';

        $this->app->config->set('glove.logLevels', [
            Exception::class => $logLevel
        ]);
        $loggerInterface = Mockery::mock(LoggerInterface::class);
        $loggerInterface->shouldReceive($logLevel)->once();

        $e      = new Exception;
        $logger = $this->app->make(Logger::class, ['logger' => $loggerInterface]);
        $logger->log($e);
    }

    public function testIgnore()
    {
        $logLevel = 'ignore';

        $this->app->config->set('glove.logLevels', [
            Exception::class => $logLevel
        ]);
        $loggerInterface = Mockery::mock(LoggerInterface::class);
        $loggerInterface->shouldNotReceive($logLevel);

        $e      = new Exception;
        $logger = $this->app->make(Logger::class, ['logger' => $loggerInterface]);
        $logger->log($e);
    }

    public function testNoLogLevels()
    {
        $this->app->config->set('glove.logLevels', []);
        $e      = new Exception;
        $logger = $this->app->make(Logger::class);
        $this->assertNull($logger->log($e));
    }

    public function testAuthError()
    {
        $logLevel = 'error';
        $this->app->config->set('glove.logLevels', [
            Exception::class => $logLevel
        ]);
        $loggerInterface = Mockery::mock(LoggerInterface::class);
        $loggerInterface->shouldReceive($logLevel)->once();

        $e      = new Exception;
        $logger = $this->app->make(Logger::class, ['logger' => $loggerInterface]);
        $logger->log($e);
    }
}
