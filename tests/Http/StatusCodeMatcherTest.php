<?php
namespace DerekHamilton\Tests\Glove\Http;

use DerekHamilton\Glove\Http\StatusCodeMatcher;
use Exception;
use Mockery;

class StatusCodeMatcherTest extends \DerekHamilton\Tests\Glove\TestCase
{
    public function testMatch()
    {
        $code = '999';
        $this->app->config->set('glove.statusCodes', $codes = [
            Exception::class => $code
        ]);
        $codeMatcher = $this->app->make(StatusCodeMatcher::class);
        $e = new Exception;
        $response = $codeMatcher->match($e);
        $this->assertSame($response, $code);
    }
}
