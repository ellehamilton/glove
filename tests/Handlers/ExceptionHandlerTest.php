<?php
namespace DerekHamilton\Tests\Glove\Handlers;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use DerekHamilton\Glove\Handlers\ExceptionHandler;
use DerekHamilton\Glove\Renderers\CatchAllRenderer;
use DerekHamilton\Tests\Glove\Stubs\HandlerStub;
use Exception;
use Mockery;

class ExceptionHandlerTest extends \DerekHamilton\Tests\Glove\TestCase
{
    public function testHandle()
    {
        $view = Mockery::mock(View::class);
        $code = 501;
        $e = new HttpException($code);
        $renderer = Mockery::mock(CatchAllRenderer::class);
        $renderer->shouldReceive('render')->once()->with($e, $code)->andReturn($view);

        $handler = $this->app->make(ExceptionHandler::class, ['renderer' => $renderer]);
        $request = $this->app->make(Request::class);
        $response = $handler->handle($request, $e);
        $this->assertInstanceOf(View::class, $response);
    }
}
