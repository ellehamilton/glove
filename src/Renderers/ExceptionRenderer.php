<?php
namespace DerekHamilton\Glove\Renderers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Container\Container;
use Exception;

class ExceptionRenderer
{
    /** @var HandlerTypesRenderer */
    private $renderer;

    /** @var array */
    private $handlers;

    /**
     * @param Container           $app
     * @param HandlerTypeRenderer $renderer
     */
    public function __construct(Container $app, HandlerTypesRenderer $renderer)
    {
        $this->renderer = $renderer;
        $this->handlers = $app->config->get('glove.handlers', []);
    }

    /**
     * @param Request   $request
     * @param Exception $e
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function render(Request $request, Exception $e)
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
