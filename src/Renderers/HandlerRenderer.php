<?php
namespace DerekHamilton\Glove\Renderers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Container\Container;
use DerekHamilton\Glove\Contracts\Handler;
use Exception;

class HandlerRenderer
{
    /** @var Container */
    private $app;

    /**
     * @param Container $app
     */
    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    /**
     * @param string    $handlerClass
     * @param Request   $request
     * @param Exception $e
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function render($handlerClass, Request $request, Exception $e)
    {
        $handler = $this->app->make($handlerClass);

        if ($handler) {
            return $handler->handle($request, $e);
        }
    }
}
