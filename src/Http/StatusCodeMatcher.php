<?php
namespace DerekHamilton\Glove\Http;

use Illuminate\Contracts\Container\Container;
use Exception;

class StatusCodeMatcher
{
    /** @var array */
    private $codes;

    /**
     * @param Container $app
     */
    public function __construct(Container $app)
    {
        $this->codes = $app->config->get('glove.statusCodes', []);
    }

    /**
     * @param Exception $e
     * @return string
     */
    public function match(Exception $e)
    {
        foreach ($this->codes as $exception => $code) {
            if ($e instanceof $exception) {
                return $code;
            }
        }

        return '500';
    }
}
