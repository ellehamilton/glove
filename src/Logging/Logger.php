<?php
namespace DerekHamilton\Glove\Logging;

use DerekHamilton\Glove\Contracts\Logging\Logger as LoggerContract;
use Illuminate\Contracts\Container\Container;
use Psr\Log\LoggerInterface;
use Throwable;

class Logger implements LoggerContract
{
    /** @var LoggerInterface */
    private $logger;

    /** @var array */
    private $logLevels;

    /**
     * @param Container       $container
     * @param LoggerInterface $logger
     */
    public function __construct(
        Container $container,
        LoggerInterface $logger
    ) {
        $this->logger    = $logger;
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
        return [];
    }
}
