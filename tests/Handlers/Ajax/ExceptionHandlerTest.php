<?php
namespace ElleHamilton\Tests\Glove\Handlers\Ajax;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use ElleHamilton\Glove\Handlers\Ajax\ExceptionHandler;
use ElleHamilton\Glove\Renderers\CatchAllRenderer;
use ElleHamilton\Tests\Glove\Stubs\HandlerStub;
use Exception;
use Mockery;

class ExceptionHandlerTest extends \ElleHamilton\Tests\Glove\TestCase
{
    public function testHandle()
    {
        $response = Mockery::mock(Response::class);
        $code = 501;
        $e = new HttpException($code);
        $renderer = Mockery::mock(CatchAllRenderer::class);
        $renderer->shouldReceive('render')->once()->with($e, $code, 'ajax')->andReturn($response);

        $handler = $this->app->make(ExceptionHandler::class, ['renderer' => $renderer]);
        $request = $this->app->make(Request::class);
        $response = $handler->handle($request, $e);
        $this->assertInstanceOf(Response::class, $response);
    }
}
