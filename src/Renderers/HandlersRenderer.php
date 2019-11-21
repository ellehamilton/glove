<?php
namespace DerekHamilton\Glove\Renderers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HandlersRenderer
{
    /** @var HandlerRenderer */
    private $renderer;

    /**
     * @param HandlerRenderer $renderer
     */
    public function __construct(HandlerRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @param array     $handlers
     * @param Request   $request
     * @param Exception $e
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function render(array $handlers, Request $request, Exception $e)
    {
        foreach ($handlers as $handler) {
            $response = $this->renderer->render($handler, $request, $e);

            // if a Response is not returned, we want to continue processing
            // further handlers instead of halting
            if ($response instanceof Response) {
                return $response;
            }
        }
    }
}
