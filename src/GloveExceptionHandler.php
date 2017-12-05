<?php
namespace DerekHamilton\Glove;

use Illuminate\Contracts\Debug\ExceptionHandler;
use DerekHamilton\Glove\Renderers\ExceptionRenderer;
use DerekHamilton\Glove\Renderers\ConsoleRenderer;
use DerekHamilton\Glove\Renderers\SimpleExceptionRenderer;
use DerekHamilton\Glove\Logging\Logger;
use Exception;

/**
 * Global Exception Handler
 *
 * Processes any otherwise uncaught exceptions and defers their processing to
 * whichever Handler is most appropriate per the config in config/glove.php
 */
class GloveExceptionHandler implements ExceptionHandler
{
    /** @var ExceptionRenderer */
    protected $exceptionRenderer;

    /** @var ConsoleRenderer */
    protected $consoleRenderer;

    /** @var SimpleExceptionRenderer */
    protected $simpleRenderer;

    /** @var Logger */
    protected $logger;

    /**
     * @param ExceptionRenderer       $exceptionRenderer
     * @param ConsoleRenderer         $consoleRenderer
     * @param SimpleExceptionRenderer $simpleRenderer
     * @param Logger                  $logger
     */
    public function __construct(
        ExceptionRenderer $exceptionRenderer,
        ConsoleRenderer $consoleRenderer,
        SimpleExceptionRenderer $simpleRenderer,
        Logger $logger
    ) {
        $this->exceptionRenderer = $exceptionRenderer;
        $this->consoleRenderer   = $consoleRenderer;
        $this->simpleRenderer    = $simpleRenderer;
        $this->logger            = $logger;
    }

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $e
     * @return mixed
     *
     * @throws \Exception
     */
    public function report(Exception $e)
    {
        $this->logger->log($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $e)
    {
        return $this->exceptionRenderer->render($request, $e) ?: $this->simpleRenderer->render($e);
    }

    /**
     * Render an exception to the console.
     *
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @param  \Exception  $e
     * @return void
     */
    public function renderForConsole($output, Exception $e)
    {
        $this->consoleRenderer->render($output, $e);
    }
}
