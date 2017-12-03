<?php
namespace DerekHamilton\Tests\Glove\Handlers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Config\Repository as Configuration;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DerekHamilton\Glove\Handlers\WhoopsHandler;
use Exception;
use Mockery;

class WhoopsHandlerTest extends \PHPUnit\Framework\TestCase
{
    public function testExceptionCaughtNotDebug()
    {
        $responseFactory = Mockery::mock(ResponseFactory::class);
        $viewFactory = Mockery::mock(ViewFactory::class);
        $config = Mockery::mock(Configuration::class);
        $config->shouldReceive('get')->with('app.debug')->andReturn(false);
        $request = Mockery::mock(Request::class);
        $e = new Exception;

        $handler = new WhoopsHandler($responseFactory, $viewFactory, $config);
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
        $request = Mockery::mock(Request::class);
        $e = new Exception;

        $handler = new WhoopsHandler($responseFactory, $viewFactory, $config);
        $this->assertInstanceOf(Response::class, $handler->handle($request, $e));
    }
}
