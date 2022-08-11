<?php
namespace ElleHamilton\Tests\Glove;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\Console\Output\OutputInterface;
use ElleHamilton\Glove\Renderers\ExceptionRenderer;
use ElleHamilton\Glove\Renderers\ConsoleRenderer;
use ElleHamilton\Glove\Renderers\SimpleExceptionRenderer;
use ElleHamilton\Glove\Logging\Logger;
use ElleHamilton\Glove\GloveExceptionHandler;
use Exception;
use Mockery;

class GloveExceptionHandlerTest extends \ElleHamilton\Tests\Glove\TestCase
{
    public function testReport()
    {
        $e = new Exception;

        $exceptionRenderer = Mockery::mock(ExceptionRenderer::class);
        $consoleRenderer = Mockery::mock(ConsoleRenderer::class);
        $simpleRenderer = Mockery::mock(SimpleExceptionRenderer::class);
        $logger = Mockery::mock(Logger::class);
        $logger->shouldReceive('log')->once()->with($e);

        $handler = new GloveExceptionHandler($exceptionRenderer, $consoleRenderer, $simpleRenderer, $logger);
        $handler->report($e);
    }

    public function testRender()
    {
        $e = new Exception;
        $request = Mockery::mock(Request::class);
        $response = Mockery::mock(Response::class);

        $exceptionRenderer = Mockery::mock(ExceptionRenderer::class);
        $consoleRenderer = Mockery::mock(ConsoleRenderer::class);
        $simpleRenderer = Mockery::mock(SimpleExceptionRenderer::class);
        $logger = Mockery::mock(Logger::class);
        $exceptionRenderer->shouldReceive('render')->once()->with($request, $e)->andReturn($response);

        $handler = new GloveExceptionHandler($exceptionRenderer, $consoleRenderer, $simpleRenderer, $logger);
        $this->assertSame($response, $handler->render($request, $e));
    }

    public function testRenderSimple()
    {
        $e = new Exception;
        $request = Mockery::mock(Request::class);
        $response = Mockery::mock(Response::class);

        $exceptionRenderer = Mockery::mock(ExceptionRenderer::class);
        $consoleRenderer = Mockery::mock(ConsoleRenderer::class);
        $simpleRenderer = Mockery::mock(SimpleExceptionRenderer::class);
        $logger = Mockery::mock(Logger::class);
        $exceptionRenderer->shouldReceive('render')->once()->with($request, $e)->andReturn(null);
        $simpleRenderer->shouldReceive('render')->once()->with($e)->andReturn($response);

        $handler = new GloveExceptionHandler($exceptionRenderer, $consoleRenderer, $simpleRenderer, $logger);
        $this->assertSame($response, $handler->render($request, $e));
    }

    public function testRenderForConsole()
    {
        $e = new Exception;
        $output = Mockery::mock(OutputInterface::class);

        $exceptionRenderer = Mockery::mock(ExceptionRenderer::class);
        $consoleRenderer = Mockery::mock(ConsoleRenderer::class);
        $simpleRenderer = Mockery::mock(SimpleExceptionRenderer::class);
        $logger = Mockery::mock(Logger::class);
        $consoleRenderer->shouldReceive('render')->once()->with($output, $e);

        $handler = new GloveExceptionHandler($exceptionRenderer, $consoleRenderer, $simpleRenderer, $logger);
        $handler->renderForConsole($output, $e);
    }

    public function testShouldReport()
    {
        $e = new Exception;
        $output = Mockery::mock(OutputInterface::class);

        $exceptionRenderer = Mockery::mock(ExceptionRenderer::class);
        $consoleRenderer = Mockery::mock(ConsoleRenderer::class);
        $simpleRenderer = Mockery::mock(SimpleExceptionRenderer::class);
        $logger = Mockery::mock(Logger::class);

        $handler = new GloveExceptionHandler($exceptionRenderer, $consoleRenderer, $simpleRenderer, $logger);
        $this->assertTrue($handler->shouldReport($e));
    }
}
