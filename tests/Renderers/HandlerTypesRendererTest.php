<?php
namespace ElleHamilton\Tests\Glove\Renderers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use ElleHamilton\Glove\Renderers\ExceptionRenderer;
use ElleHamilton\Glove\Renderers\HandlerTypesRenderer;
use ElleHamilton\Tests\Glove\Stubs\HandlerStub;
use Exception;
use Mockery;

class HandlerTypesRendererTest extends \ElleHamilton\Tests\Glove\TestCase
{
    public function testRender()
    {
        $handlerTypes = [
            'ajax' => [
                Exception::class => [
                    HandlerStub::class
                ]
            ]
        ];
        $renderer = $this->app->make(HandlerTypesRenderer::class);
        $request = $this->app->make(Request::class);
        $e = new Exception;
        $response = $renderer->render('ajax', $handlerTypes, $request, $e);

        $this->assertInstanceOf(Response::class, $response);
    }

    public function testNoMatch()
    {
        $handlerTypes = [
            'ajax' => [
            ]
        ];
        $renderer = $this->app->make(HandlerTypesRenderer::class);
        $request = $this->app->make(Request::class);
        $e = new Exception;
        $response = $renderer->render('ajax', $handlerTypes, $request, $e);

        $this->assertNull($response);
    }
}
