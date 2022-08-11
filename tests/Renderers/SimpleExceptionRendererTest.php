<?php

namespace ElleHamilton\Tests\Glove\Renderers;

use ElleHamilton\Glove\Renderers\SimpleExceptionRenderer;
use Exception;
use Mockery;

class SimpleExceptionRendererTest extends \ElleHamilton\Tests\Glove\TestCase
{
    public function testRender()
    {
        $renderer = $this->app->make(SimpleExceptionRenderer::class);
        $e = new Exception("foo");
        $this->assertStringContainsString("foo", "".$renderer->render($e));
    }
}
