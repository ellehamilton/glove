<?php
namespace ElleHamilton\Tests\Glove\Renderers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\Container\Container;
use Illuminate\Config\Repository as Configuration;
use ElleHamilton\Glove\Renderers\ExceptionRenderer;
use ElleHamilton\Glove\Renderers\HandlerRenderer;
use ElleHamilton\Tests\Glove\Stubs\HandlerStub;
use Exception;
use Mockery;

class HandlerRendererTest extends \ElleHamilton\Tests\Glove\TestCase
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
