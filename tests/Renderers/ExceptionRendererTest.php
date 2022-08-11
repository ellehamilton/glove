<?php
namespace ElleHamilton\Tests\Glove\Renderers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\Container\Container;
use Illuminate\Config\Repository as Configuration;
use ElleHamilton\Glove\Renderers\ExceptionRenderer;
use ElleHamilton\Glove\Renderers\HandlerTypesRenderer;
use ElleHamilton\Glove\Contracts\Handler;
use ElleHamilton\Tests\Glove\Stubs\HandlerStub;
use Exception;
use Mockery;

class ExceptionRendererTest extends \ElleHamilton\Tests\Glove\TestCase
{
    public function testAjax()
    {
        $this->renderTest('ajax', true);
    }

    public function testHttp()
    {
        $this->renderTest('http', false);
    }

    public function testGlobal()
    {
        $this->renderTest('global', false);
    }

    private function renderTest($type, $ajax)
    {
        $handlers = [
            $type => [
                Exception::class => [
                    HandlerStub::class
                ]
            ]
        ];
        $config = Mockery::mock(Configuration::class);
        $config->shouldReceive('get')->with('glove.handlers', [])->andReturn($handlers);
        $app = Mockery::mock(Container::class);
        $app->config = $config;

        $request = Mockery::mock(Request::class);
        $request->shouldReceive('ajax')->andReturn($ajax);
        $e = new Exception;

        $renderer = $this->app->make(HandlerTypesRenderer::class);
        $exceptionRenderer = new ExceptionRenderer($app, $renderer);
        $response = $exceptionRenderer->render($request, $e);

        $this->assertInstanceOf(Response::class, $response);
    }
}
