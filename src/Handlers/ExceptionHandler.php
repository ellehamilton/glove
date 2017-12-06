<?php
namespace DerekHamilton\Glove\Handlers;

use DerekHamilton\Glove\Contracts\Handler;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;
use DerekHamilton\Glove\Http\StatusCodeMatcher;
use Exception;

/**
 * General Exception Handler
 *
 * Any otherwise uncaught exceptions will end up here.
 */
class ExceptionHandler implements Handler
{
    /** @var \Illuminate\Config\Repository */
    private $config;

    /** @var ResponseFactory */
    private $responseFactory;

    /** @var ViewFactory */
    private $viewFactory;

    /** @var StatusCodeMatcher */
    private $codeMatcher;

    /**
     * @param Container         $container
     * @param ResponseFactory   $responseFactory
     * @param ViewFactory       $viewFactory
     * @param StatusCodeMatcher $codeMatcher
     */
    public function __construct(
        Container $container,
        ResponseFactory $responseFactory,
        ViewFactory $viewFactory,
        StatusCodeMatcher $codeMatcher
    ) {
        $this->config = $container->config;
        $this->responseFactory = $responseFactory;
        $this->viewFactory = $viewFactory;
        $this->codeMatcher = $codeMatcher;
    }

    public function handle(Request $request, Exception $e)
    {
        $code = $this->codeMatcher->match($e);
        $viewData = $this->config->get('glove-codes.'.$code.'.data');
        $viewData = is_array($viewData) ? $viewData : [];

        $data = array_merge(
            [
                'e' => $e,
                'code' => $code,
            ],
            $viewData
        );
        $view = $this->config->get('glove-codes.'.$code.'.view');

        return $this->responseFactory->make(
            $this->viewFactory->make($view, $data)->render(),
            $code
        );
    }
}
