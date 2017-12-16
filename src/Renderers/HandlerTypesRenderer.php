<?php
namespace DerekHamilton\Glove\Renderers;

use Illuminate\Http\Request;
use Exception;

class HandlerTypesRenderer
{
    /** @var HandlerTypeRenderer */
    private $renderer;

    /**
     * @param HandlerTypeRenderer $renderer
     */
    public function __construct(HandlerTypeRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @param string    $type
     * @param array     $handlerTypes
     * @param Request   $request
     * @param Exception $e
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function render(string $type, array $handlerTypes, Request $request, Exception $e)
    {
        $handlerType = array_get($handlerTypes, $type, []);
        return $this->renderer->render($handlerType, $request, $e);
    }
}
