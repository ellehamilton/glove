<?php
namespace DerekHamilton\Glove\Logging;

use DerekHamilton\Glove\Contracts\Logging\Logger as LoggerContract;
use Illuminate\Contracts\Auth\Guard as Authentication;
use Illuminate\Contracts\Container\Container;
use Psr\Log\LoggerInterface;
use Throwable;

class Logger implements LoggerContract
{
    /** @var LoggerInterface */
    private $logger;

    /** @var Authentication */
    private $auth;

    /** @var array */
    private $logLevels;

    /**
     * @param Container       $container
     * @param LoggerInterface $logger
     * @param Authentication  $auth
     */
    public function __construct(
        Container $container,
        LoggerInterface $logger,
        Authentication $auth
    ) {
        $this->logger    = $logger;
        $this->auth      = $auth;
        $this->logLevels = $container->config->get('glove.logLevels', []);
    }

    /**
     * @param Throwable $e
     * @return void
     */
    public function log(Throwable $e)
    {
        foreach ($this->logLevels as $exception => $logLevel) {
            if ($e instanceof $exception) {
                if ($logLevel === 'ignore') {
                    return;
                }

                $this->logger->$logLevel(
                    $e->getMessage(),
                    array_merge($this->context(), ['exception' => $e])
                );
                return;
            }
        }
    }

    /**
     * Get the default context variables for logging.
     *
     * @return array
     */
    private function context()
    {
        try {
            return array_filter([
                'userId' => $this->auth->id(),
                'email'  => $this->auth->user() ? $this->auth->user()->email : null,
            ]);
        } catch (Throwable $e) {
            return [];
        }
    }
}
