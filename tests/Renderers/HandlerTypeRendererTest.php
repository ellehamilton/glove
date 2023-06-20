<?php

namespace ElleTheDev\Tests\Glove\Renderers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use ElleTheDev\Glove\Renderers\ExceptionRenderer;
use ElleTheDev\Glove\Renderers\HandlerTypeRenderer;
use ElleTheDev\Tests\Glove\Stubs\HandlerStub;
use Exception;
use Mockery;

class HandlerTypeRendererTest extends \ElleTheDev\Tests\Glove\TestCase
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
        $e = new Exception();
        $response = $renderer->render($exceptions, $request, $e);

        $this->assertInstanceOf(Response::class, $response);
    }

    public function testNoMatch()
    {
        $exceptions = [
        ];
        $renderer = $this->app->make(HandlerTypeRenderer::class);
        $request = $this->app->make(Request::class);
        $e = new Exception();
        $response = $renderer->render($exceptions, $request, $e);

        $this->assertNull($response);
    }
}
