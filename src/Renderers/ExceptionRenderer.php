<?php

namespace ElleTheDev\Glove\Renderers;

use Throwable;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;

class ExceptionRenderer
{
    /** @var HandlerTypesRenderer */
    private $renderer;

    /** @var array */
    private $handlers;

    /**
     * @param Container            $container
     * @param HandlerTypesRenderer $renderer
     */
    public function __construct(Container $container, HandlerTypesRenderer $renderer)
    {
        $this->renderer = $renderer;
        $this->handlers = $container->config->get('glove.handlers', []);
    }

    /**
     * @param Request   $request
     * @param Throwable $e
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function render(Request $request, Throwable $e)
    {
        if ($request->ajax()) {
            $response = $this->renderer->render('ajax', $this->handlers, $request, $e);
        } else {
            $response = $this->renderer->render('http', $this->handlers, $request, $e);
        }

        if ($response) {
            return $response;
        }


        return $this->renderer->render('global', $this->handlers, $request, $e);
    }
}
