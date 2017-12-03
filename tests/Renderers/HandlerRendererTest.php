<?php
namespace DerekHamilton\Tests\Glove\Renderers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\Container\Container;
use Illuminate\Config\Repository as Configuration;
use DerekHamilton\Glove\Renderers\ExceptionRenderer;
use DerekHamilton\Glove\Renderers\HandlerRenderer;
use DerekHamilton\Tests\Glove\Stubs\HandlerStub;
use Exception;
use Mockery;

class HandlerRendererTest extends \DerekHamilton\Tests\Glove\TestCase
{
    public function testRender()
    {
        $handlerClass = HandlerStub::class;
        $renderer = $this->app->make(HandlerRenderer::class);
        $request = $this->app->make(Request::class);
        $e = new Exception;
        $response = $renderer->render($handlerClass, $request, $e);

        $this->assertInstanceOf(Response::class, $response);
    }
}
