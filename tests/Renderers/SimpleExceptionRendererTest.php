<?php
namespace DerekHamilton\Tests\Glove\Renderers;

use DerekHamilton\Glove\Renderers\SimpleExceptionRenderer;
use Exception;
use Mockery;

class SimpleExceptionRendererTest extends \DerekHamilton\Tests\Glove\TestCase
{
    public function testRender()
    {
        $renderer = $this->app->make(SimpleExceptionRenderer::class);
        $e = new Exception("foo");
        $this->assertContains("foo", "".$renderer->render($e));
    }
}
