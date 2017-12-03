<?php
namespace DerekHamilton\Glove\Renderers;

use Illuminate\Http\Request;
use Exception;

class HandlerTypesRenderer
{
    /** @var ExceptionHandlersRenderer */
    private $renderer;

    /**
     * @param ExceptionHandlerRenderer $renderer
     */
    public function __construct(HandlerTypeRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @param array     $handlerTypes
     * @param string    $type
     * @param Request   $request
     * @param Exception $e
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function render($type, array $handlerTypes, Request $request, Exception $e)
    {
        $handlerType = array_get($handlerTypes, $type, []);
        return $this->renderer->render($handlerType, $request, $e);
    }
}
