<?php
namespace DerekHamilton\Glove\Renderers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Container\Container;
use DerekHamilton\Glove\Contracts\Handler;
use Exception;

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
