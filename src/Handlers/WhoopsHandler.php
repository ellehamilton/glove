<?php
namespace DerekHamilton\Glove\Handlers;

use DerekHamilton\Glove\Contracts\Handler;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Http\Request;
use Illuminate\Config\Repository as Configuration;
use Whoops\Run as Whoops;
use Whoops\Handler\PrettyPageHandler;
use Exception;

/**
 * Handler for integrating filp/whoops package
 */
class WhoopsHandler implements Handler
{
    /** @var ResponseFactory */
    private $responseFactory;

    /** @var ViewFactory */
    private $viewFactory;

    /** @var boolean */
    private $debug;

    /**
     * @param ResponseFactory $responseFactory
     * @param ViewFactory     $viewFactory
     */
    public function __construct(
        ResponseFactory $responseFactory,
        ViewFactory $viewFactory,
        Configuration $config
    ) {
        $this->responseFactory = $responseFactory;
        $this->viewFactory = $viewFactory;
        $this->debug = $config->get('app.debug');
    }

    public function handle(Request $request, Exception $e)
    {
        if ($this->debug && class_exists(Whoops::class)) {
            return $this->whoopsResponse($e);
        }
    }

    /**
     * @param Exception $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function whoopsResponse(Exception $e)
    {
        $whoops = new Whoops;
        $whoops->pushHandler(new PrettyPageHandler);
        return $this->responseFactory->make(
            $whoops->handleException($e),
            500
        );
    }
}
