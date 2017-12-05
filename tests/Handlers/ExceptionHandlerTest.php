<?php
namespace DerekHamilton\Tests\Glove\Handlers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\View\View;
use DerekHamilton\Glove\Handlers\ExceptionHandler;
use DerekHamilton\Tests\Glove\Stubs\HandlerStub;
use Exception;
use Mockery;

class ExceptionHandlerTest extends \DerekHamilton\Tests\Glove\TestCase
{
    public function testHandle()
    {
        $viewString = 'foo';
        $this->app->config->set('glove-codes.500.view', 'vendor.glove.exception');

        $view = Mockery::mock(View::class);
        $view->shouldReceive('render')->andReturn($viewString);
        $viewFactory = Mockery::mock(ViewFactory::class);
        $viewFactory->shouldReceive('make')
            ->with('vendor.glove.exception', Mockery::type('array'))
            ->andReturn($view);

        $response = Mockery::mock(Response::class);
        $responseFactory = Mockery::mock(ResponseFactory::class);
        $responseFactory->shouldReceive('make')->with($viewString, Mockery::type('int'))->andReturn($response);

        $handler = $this->app->make(ExceptionHandler::class, ['responseFactory' => $responseFactory, 'viewFactory' => $viewFactory]);
        $request = $this->app->make(Request::class);
        $e = new Exception;
        $response = $handler->handle($request, $e);
        $this->assertInstanceOf(Response::class, $response);
    }
}
