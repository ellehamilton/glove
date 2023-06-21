<?php

namespace ElleTheDev\Glove;

use ElleTheDev\Glove\Logging\Logger;
use ElleTheDev\Glove\Renderers\ConsoleRenderer;
use ElleTheDev\Glove\Renderers\ExceptionRenderer;
use ElleTheDev\Glove\Renderers\SimpleExceptionRenderer;
use Illuminate\Config\Repository as Configuration;
use Illuminate\Foundation\Exceptions\Handler;
use Throwable;

/**
 * Global Exception Handler
 *
 * Processes any otherwise uncaught exceptions and defers their processing to
 * whichever Handler is most appropriate per the config in config/glove.php
 */
class GloveExceptionHandler extends Handler
{
    /** @var ExceptionRenderer */
    protected $exceptionRenderer;

    /** @var ConsoleRenderer */
    protected $consoleRenderer;

    /** @var SimpleExceptionRenderer */
    protected $simpleRenderer;

    /** @var Logger */
    protected $logger;

    /** @var Configuration */
    protected $config;

    protected $dontReport = [];

    /**
     * @param ExceptionRenderer       $exceptionRenderer
     * @param ConsoleRenderer         $consoleRenderer
     * @param SimpleExceptionRenderer $simpleRenderer
     * @param Logger                  $logger
     * @param Configuration           $config
     */
    public function __construct(
        ExceptionRenderer $exceptionRenderer,
        ConsoleRenderer $consoleRenderer,
        SimpleExceptionRenderer $simpleRenderer,
        Logger $logger,
        Configuration $config
    ) {
        $this->exceptionRenderer = $exceptionRenderer;
        $this->consoleRenderer   = $consoleRenderer;
        $this->simpleRenderer    = $simpleRenderer;
        $this->logger            = $logger;
        $this->config            = $config;
        $this->dontReport        = $this->config->get('glove.skip');
    }

    /**
     * Report or log an exception.
     *
     * @param \Throwable $e
     * @return mixed
     *
     * @throws \Throwable
     */
    public function report(Throwable $e)
    {
        $this->logger->log($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable               $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $e)
    {
        if ($this->shouldntReport($e)) {
            return parent::render($request, $e);
        }
        return $this->exceptionRenderer->render($request, $e) ?: $this->simpleRenderer->render($e);
    }

    /**
     * Render an exception to the console.
     *
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param \Throwable                                        $e
     * @return void
     */
    public function renderForConsole($output, Throwable $e)
    {
        $this->consoleRenderer->render($output, $e);
    }


    /**
     * Determine if the exception should be reported.
     *
     * @param \Throwable $e
     * @return bool
     */
    public function shouldReport(Throwable $e)
    {
        // ignoring is handled using `logLevels` in `config/glove.php`
        $dontReport = $this->config->get('glove.dontReport', []);
        foreach ($dontReport as $className) {
            if ($e instanceof $className) {
                return false;
            }
        }
        return true;
    }
}
