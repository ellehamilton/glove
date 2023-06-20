<?php

namespace ElleTheDev\Tests\Glove\Http;

use Symfony\Component\HttpKernel\Exception\HttpException;
use ElleTheDev\Glove\Http\StatusCodeMatcher;
use Exception;
use Mockery;

class StatusCodeMatcherTest extends \ElleTheDev\Tests\Glove\TestCase
{
    public function testMatch()
    {
        $code = 999;
        $this->app->config->set('glove.statusCodes', $codes = [
            Exception::class => $code
        ]);
        $codeMatcher = $this->app->make(StatusCodeMatcher::class);
        $e = new Exception();
        $response = $codeMatcher->match($e);
        $this->assertSame($response, $code);
    }

    public function testMatchHttpException()
    {
        $code = 999;
        $this->app->config->set('glove.statusCodes', $codes = [
        ]);
        $codeMatcher = $this->app->make(StatusCodeMatcher::class);
        $e = new HttpException($code);
        $response = $codeMatcher->match($e);
        $this->assertSame($response, $code);
    }

    public function testNoMatch()
    {
        $code = 999;
        $this->app->config->set('glove.statusCodes', $codes = [
        ]);
        $codeMatcher = $this->app->make(StatusCodeMatcher::class);
        $e = new Exception($code);
        $response = $codeMatcher->match($e);
        $this->assertSame($response, 500);
    }
}
