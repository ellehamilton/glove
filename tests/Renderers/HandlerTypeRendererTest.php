<?php
namespace ElleHamilton\Tests\Glove\Renderers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use ElleHamilton\Glove\Renderers\ExceptionRenderer;
use ElleHamilton\Glove\Renderers\HandlerTypeRenderer;
use ElleHamilton\Tests\Glove\Stubs\HandlerStub;
use Exception;
use Mockery;

class HandlerTypeRendererTest extends \ElleHamilton\Tests\Glove\TestCase
{
    public function testRender()
    {
        $exceptions = [
            // test HandlerTypeRenderer is skipped over properly
            HandlerTypeRenderer::class => [
            ],
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
