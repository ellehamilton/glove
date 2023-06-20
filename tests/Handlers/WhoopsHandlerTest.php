<?php

namespace ElleTheDev\Tests\Glove\Handlers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Config\Repository as Configuration;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use ElleTheDev\Glove\Handlers\WhoopsHandler;
use Exception;
use Mockery;

class WhoopsHandlerTest extends \ElleTheDev\Tests\Glove\TestCase
{
    // test that Whoops isn't triggered if the application is not in
    // debug mode
    public function testExceptionCaughtNotDebug()
    {
        $responseFactory = Mockery::mock(ResponseFactory::class);
        $viewFactory = Mockery::mock(ViewFactory::class);
        $config = Mockery::mock(Configuration::class);
        $config->shouldReceive('get')->with('app.debug')->andReturn(false);
        $config->shouldReceive('get')->with('glove-codes.500.debug', true)->andReturn(true);
        $request = Mockery::mock(Request::class);
        $e = new Exception();

        $handler = $this->app->make(WhoopsHandler::class, [
            'responseFactory' => $responseFactory,
            'viewFactory' => $viewFactory,
            'config' => $config
        ]);
        $this->assertNull($handler->handle($request, $e));
    }

    // test that Whoops isn't triggered if the glove-codes view setting has
    // debug => false to not show debug for that particular code
    public function testExceptionCaughtNotShow()
    {
        $responseFactory = Mockery::mock(ResponseFactory::class);
        $viewFactory = Mockery::mock(ViewFactory::class);
        $config = Mockery::mock(Configuration::class);
        $config->shouldReceive('get')->with('app.debug')->andReturn(true);
        $config->shouldReceive('get')->with('glove-codes.500.debug', true)->andReturn(false);
        $request = Mockery::mock(Request::class);
        $e = new Exception();

        $handler = $this->app->make(WhoopsHandler::class, [
            'responseFactory' => $responseFactory,
            'viewFactory' => $viewFactory,
            'config' => $config
        ]);
        $this->assertNull($handler->handle($request, $e));
    }

    public function testExceptionCaughtDebug()
    {
        $response = Mockery::mock(Response::class);
        $responseFactory = Mockery::mock(ResponseFactory::class);
        $responseFactory->shouldReceive('make')->once()->andReturn($response);
        $viewFactory = Mockery::mock(ViewFactory::class);
        $config = Mockery::mock(Configuration::class);
        $config->shouldReceive('get')->with('app.debug')->andReturn(true);
        $config->shouldReceive('get')->with('glove-codes.500.debug', true)->andReturn(true);
        $request = Mockery::mock(Request::class);
        $e = new Exception();

        $handler = $this->app->make(WhoopsHandler::class, [
            'responseFactory' => $responseFactory,
            'viewFactory' => $viewFactory,
            'config' => $config
        ]);
        $this->assertInstanceOf(Response::class, $handler->handle($request, $e));
    }
}
