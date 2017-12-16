<?php
namespace DerekHamilton\Glove\Renderers;

use DerekHamilton\Glove\Contracts\Handler;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;
use Exception;

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
     * @param Container         $container
     * @param ResponseFactory   $responseFactory
     * @param ViewFactory       $viewFactory
     * @param StatusCodeMatcher $codeMatcher
     */
    public function __construct(
        Container $container,
        ResponseFactory $responseFactory,
        ViewFactory $viewFactory
    ) {
        $this->config = $container->config;
        $this->responseFactory = $responseFactory;
        $this->viewFactory = $viewFactory;
    }

    /**
     * @param Exception $e
     * @param integer   $code
     * @param string    $method glove-codes.$code.view.$method
     * @return \Illuminate\View\View
     */
    public function render(Exception $e, $code, $method)
    {
        $viewData = $this->config->get('glove-codes.'.$code.'.data');
        $viewData = is_array($viewData) ? $viewData : [];

        $data = array_merge(
            [
                'e' => $e,
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
