<?php

namespace ElleTheDev\Tests\Glove;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\Console\Output\OutputInterface;
use ElleTheDev\Glove\Renderers\ExceptionRenderer;
use ElleTheDev\Glove\Renderers\ConsoleRenderer;
use ElleTheDev\Glove\Renderers\SimpleExceptionRenderer;
use ElleTheDev\Glove\Logging\Logger;
use ElleTheDev\Glove\GloveExceptionHandler;
use Exception;
use Mockery;
use Illuminate\Config\Repository as Configuration;

class GloveExceptionHandlerTest extends \ElleTheDev\Tests\Glove\TestCase
{
    public function testReport()
    {
        $e = new Exception();

        $exceptionRenderer = Mockery::mock(ExceptionRenderer::class);
        $consoleRenderer = Mockery::mock(ConsoleRenderer::class);
        $simpleRenderer = Mockery::mock(SimpleExceptionRenderer::class);
        $logger = Mockery::mock(Logger::class);
        $logger->shouldReceive('log')->once()->with($e);
        $config = Mockery::mock(Configuration::class);
        $config->shouldReceive('get')->with('glove.skip')->andReturn([]);

        $handler = new GloveExceptionHandler($exceptionRenderer, $consoleRenderer, $simpleRenderer, $logger, $config);
        $handler->report($e);
    }

    public function testRender()
    {
        $e = new Exception();
        $request = Mockery::mock(Request::class);
        $response = Mockery::mock(Response::class);

        $exceptionRenderer = Mockery::mock(ExceptionRenderer::class);
        $consoleRenderer = Mockery::mock(ConsoleRenderer::class);
        $simpleRenderer = Mockery::mock(SimpleExceptionRenderer::class);
        $logger = Mockery::mock(Logger::class);
        $exceptionRenderer->shouldReceive('render')->once()->with($request, $e)->andReturn($response);
        $config = Mockery::mock(Configuration::class);
        $config->shouldReceive('get')->with('glove.skip')->andReturn([]);

        $handler = new GloveExceptionHandler($exceptionRenderer, $consoleRenderer, $simpleRenderer, $logger, $config);
        $this->assertSame($response, $handler->render($request, $e));
    }

    public function testRenderSimple()
    {
        $e = new Exception();
        $request = Mockery::mock(Request::class);
        $response = Mockery::mock(Response::class);

        $exceptionRenderer = Mockery::mock(ExceptionRenderer::class);
        $consoleRenderer = Mockery::mock(ConsoleRenderer::class);
        $simpleRenderer = Mockery::mock(SimpleExceptionRenderer::class);
        $logger = Mockery::mock(Logger::class);
        $exceptionRenderer->shouldReceive('render')->once()->with($request, $e)->andReturn(null);
        $simpleRenderer->shouldReceive('render')->once()->with($e)->andReturn($response);
        $config = Mockery::mock(Configuration::class);
        $config->shouldReceive('get')->with('glove.skip')->andReturn([]);

        $handler = new GloveExceptionHandler($exceptionRenderer, $consoleRenderer, $simpleRenderer, $logger, $config);
        $this->assertSame($response, $handler->render($request, $e));
    }

    public function testRenderForConsole()
    {
        $e = new Exception();
        $output = Mockery::mock(OutputInterface::class);

        $exceptionRenderer = Mockery::mock(ExceptionRenderer::class);
        $consoleRenderer = Mockery::mock(ConsoleRenderer::class);
        $simpleRenderer = Mockery::mock(SimpleExceptionRenderer::class);
        $logger = Mockery::mock(Logger::class);
        $consoleRenderer->shouldReceive('render')->once()->with($output, $e);
        $config = Mockery::mock(Configuration::class);
        $config->shouldReceive('get')->with('glove.skip')->andReturn([]);

        $handler = new GloveExceptionHandler($exceptionRenderer, $consoleRenderer, $simpleRenderer, $logger, $config);
        $handler->renderForConsole($output, $e);
    }

    public function testShouldReport()
    {
        $e = new Exception();
        $output = Mockery::mock(OutputInterface::class);

        $exceptionRenderer = Mockery::mock(ExceptionRenderer::class);
        $consoleRenderer = Mockery::mock(ConsoleRenderer::class);
        $simpleRenderer = Mockery::mock(SimpleExceptionRenderer::class);
        $logger = Mockery::mock(Logger::class);
        $config = Mockery::mock(Configuration::class);
        $config->shouldReceive('get')->with('glove.skip')->andReturn([]);

        $handler = new GloveExceptionHandler($exceptionRenderer, $consoleRenderer, $simpleRenderer, $logger, $config);
        $this->assertTrue($handler->shouldReport($e));
    }
}
