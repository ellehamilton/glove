<?php

namespace ElleTheDev\Tests\Glove\Renderers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use ElleTheDev\Glove\Renderers\HandlersRenderer;
use ElleTheDev\Tests\Glove\Stubs\HandlerStub;
use Exception;
use Mockery;

class HandlersRendererTest extends \ElleTheDev\Tests\Glove\TestCase
{
    public function testRender()
    {
        $handlers = [
            HandlerStub::class
        ];
        $renderer = $this->app->make(HandlersRenderer::class);
        $request = $this->app->make(Request::class);
        $e = new Exception();
        $response = $renderer->render($handlers, $request, $e);

        $this->assertInstanceOf(Response::class, $response);
    }

    public function testNoMatch()
    {
        $handlers = [
        ];
        $renderer = $this->app->make(HandlersRenderer::class);
        $request = $this->app->make(Request::class);
        $e = new Exception();
        $response = $renderer->render($handlers, $request, $e);

        $this->assertNull($response);
    }
}
