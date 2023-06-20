<?php

namespace ElleTheDev\Glove\Renderers;

use Throwable;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory as ViewFactory;

/**
 * Render the exception page for a general exception
 */
class CatchAllRenderer
{
    /** @var \Illuminate\Config\Repository */
    private $config;

    /** @var ResponseFactory */
    private $responseFactory;

    /** @var ViewFactory */
    private $viewFactory;

    /**
     * @param Container       $container
     * @param ResponseFactory $responseFactory
     * @param ViewFactory     $viewFactory
     */
    public function __construct(
        Container $container,
        ResponseFactory $responseFactory,
        ViewFactory $viewFactory
    ) {
        $this->config          = $container->config;
        $this->responseFactory = $responseFactory;
        $this->viewFactory     = $viewFactory;
    }

    /**
     * @param Throwable $e
     * @param integer   $code
     * @param string    $method glove-codes.$code.view.$method
     * @return \Illuminate\Http\Response
     */
    public function render(Throwable $e, int $code, string $method): \Illuminate\Http\Response
    {
        $viewData = $this->config->get('glove-codes.'.$code.'.data');
        $viewData = is_array($viewData) ? $viewData : [];

        $data = array_merge(
            [
                'e'    => $e,
                'code' => $code,
            ],
            $viewData
        );
        $view = $this->config->get('glove-codes.'.$code.'.view.'.$method);

        return $this->responseFactory->make(
            $this->viewFactory->make($view, $data)->render(),
            $code
        );
    }
}
