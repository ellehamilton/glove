<?php

namespace ElleHamilton\Glove\Renderers;

use Throwable;
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
     * @param Throwable $e
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function render(string $type, array $handlerTypes, Request $request, Throwable $e)
    {
        $handlerType = Arr::get($handlerTypes, $type, []);
        return $this->renderer->render($handlerType, $request, $e);
    }
}
