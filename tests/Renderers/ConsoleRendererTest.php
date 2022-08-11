<?php
namespace ElleHamilton\Tests\Glove\Renderers;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Application as ConsoleApplication;
use ElleHamilton\Glove\Renderers\ConsoleRenderer;
use Exception;
use Mockery;

class ConsoleRendererTest extends \ElleHamilton\Tests\Glove\TestCase
{
    public function testRender()
    {
        $output = Mockery::mock(OutputInterface::class);
        $console = Mockery::mock(ConsoleApplication::class);
        $e = new Exception("foo");

        $console->shouldReceive('renderException')->once()->with($e, $output);
        $renderer = new ConsoleRenderer($console);
        $renderer->render($output, $e);
    }
}
