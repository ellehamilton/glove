<?php

namespace ElleTheDev\Glove\Renderers;

use Exception;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;

class HandlerRenderer
{
    /** @var Container */
    private $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param string    $handlerClass
     * @param Request   $request
     * @param Exception $e
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function render(string $handlerClass, Request $request, Exception $e)
    {
        $handler = $this->container->make($handlerClass);
        return $handler->handle($request, $e);
    }
}
