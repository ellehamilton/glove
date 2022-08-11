<?php
namespace ElleHamilton\Tests\Glove\Handlers;

use ElleHamilton\Glove\Providers\GloveServiceProvider;
use ElleHamilton\Glove\GloveExceptionHandler;
use ElleHamilton\Tests\Glove\Stubs\AppHandlerStub;
use Exception;
use Mockery;

class GloveServiceProviderTest extends \ElleHamilton\Tests\Glove\TestCase
{
    public function testBoot()
    {
        $provider = new GloveServiceProvider($this->app);
        $this->assertNull($provider->boot());
    }

    public function testRegister()
    {
        $this->app->config->set('glove.appHandler', AppHandlerStub::class);
        $provider = new GloveServiceProvider($this->app);
        $this->assertNull($provider->register());

        // test that the overridden app exception handler resolves to
        // GloveExceptionHandler as expected
        $this->assertInstanceOf(GloveExceptionHandler::class, $this->app->make(AppHandlerStub::class));
    }
}
