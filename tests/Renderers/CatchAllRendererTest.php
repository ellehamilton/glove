<?php
namespace ElleHamilton\Tests\Glove\Handlers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\View\View;
use ElleHamilton\Glove\Renderers\CatchAllRenderer;
use ElleHamilton\Tests\Glove\Stubs\HandlerStub;
use Exception;
use Mockery;

class CatchAllRendererTest extends \ElleHamilton\Tests\Glove\TestCase
{
    public function testRender()
    {
        $viewString = 'foo';
        $this->app->config->set('glove-codes.500.view.http', 'vendor.glove.exception');

        $view = Mockery::mock(View::class);
        $view->shouldReceive('render')->andReturn($viewString);
        $viewFactory = Mockery::mock(ViewFactory::class);
        $viewFactory->shouldReceive('make')
            ->with('vendor.glove.exception', Mockery::type('array'))
            ->andReturn($view);

        $response = Mockery::mock(Response::class);
        $responseFactory = Mockery::mock(ResponseFactory::class);
        $responseFactory->shouldReceive('make')->with($viewString, Mockery::type('int'))->andReturn($response);

        $renderer = $this->app->make(CatchAllRenderer::class, ['responseFactory' => $responseFactory, 'viewFactory' => $viewFactory]);
        $request = $this->app->make(Request::class);
        $e = new Exception;
        $response = $renderer->render($e, 500, 'http');
        $this->assertInstanceOf(Response::class, $response);
    }
}
