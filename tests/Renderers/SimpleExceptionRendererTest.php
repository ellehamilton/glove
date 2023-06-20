<?php

namespace ElleTheDev\Tests\Glove\Renderers;

use ElleTheDev\Glove\Renderers\SimpleExceptionRenderer;
use Exception;
use Mockery;

class SimpleExceptionRendererTest extends \ElleTheDev\Tests\Glove\TestCase
{
    public function testRender()
    {
        $renderer = $this->app->make(SimpleExceptionRenderer::class);
        $e = new Exception("foo");
        $this->assertStringContainsString("foo", "".$renderer->render($e));
    }
}
