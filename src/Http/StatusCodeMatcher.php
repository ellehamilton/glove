<?php
namespace DerekHamilton\Glove\Http;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Contracts\Container\Container;
use Exception;

class StatusCodeMatcher
{
    /** @var array */
    private $codes;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->codes = $container->config->get('glove.statusCodes', []);
    }

    /**
     * @param Exception $e
     * @return integer
     */
    public function match(Exception $e)
    {
        // abort() calls return an HttpException with the status code
        // provided as an argument. e.g. abort(403) for a 403 error.
        if ($e instanceof HttpException) {
            return $e->getStatusCode();
        }

        foreach ($this->codes as $exception => $code) {
            if ($e instanceof $exception) {
                return $code;
            }
        }

        return 500;
    }
}
