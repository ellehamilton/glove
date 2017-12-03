<?php
namespace DerekHamilton\Tests\Glove\Renderers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DerekHamilton\Glove\Renderers\ExceptionRenderer;
use DerekHamilton\Glove\Renderers\HandlerTypeRenderer;
use DerekHamilton\Tests\Glove\Stubs\HandlerStub;
use Exception;
use Mockery;

class HandlerTypeRendererTest extends \DerekHamilton\Tests\Glove\TestCase
{
    public function testRender()
    {
        $exceptions = [
            Exception::class => [
                HandlerStub::class
            ]
        ];
        $renderer = $this->app->make(HandlerTypeRenderer::class);
        $request = $this->app->make(Request::class);
        $e = new Exception;
        $response = $renderer->render($exceptions, $request, $e);

        $this->assertInstanceOf(Response::class, $response);
    }

    public function testNoMatch()
    {
        $exceptions = [
        ];
        $renderer = $this->app->make(HandlerTypeRenderer::class);
        $request = $this->app->make(Request::class);
        $e = new Exception;
        $response = $renderer->render($exceptions, $request, $e);

        $this->assertNull($response);
    }
}
