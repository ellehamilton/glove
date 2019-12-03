<?php
namespace DerekHamilton\Glove\Renderers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

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
        $handlerType = Arr::get($handlerTypes, $type, []);
        return $this->renderer->render($handlerType, $request, $e);
    }
}
