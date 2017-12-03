<?php
namespace DerekHamilton\Glove\Renderers;

use Illuminate\Http\Request;
use Exception;

class HandlerTypeRenderer
{
    /** @var ExceptionHandlersRenderer */
    private $renderer;

    /**
     * @param ExceptionHandlerRenderer $renderer
     */
    public function __construct(HandlersRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @param array     $handlerTypes
     * @param Request   $request
     * @param Exception $e
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function render(array $exceptions, Request $request, Exception $e)
    {
        foreach ($exceptions as $exceptionClass => $handlers) {
            if (!($e instanceof $exceptionClass)) {
                continue;
            }

            $response = $this->renderer->render($handlers, $request, $e);

            if ($response) {
                return $response;
            }
        }
    }
}
