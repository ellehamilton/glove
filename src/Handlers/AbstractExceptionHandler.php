<?php

namespace ElleTheDev\Glove\Handlers;

use ElleTheDev\Glove\Http\StatusCodeMatcher;
use ElleTheDev\Glove\Renderers\CatchAllRenderer;
use Throwable;
use Illuminate\Http\Request;

abstract class AbstractExceptionHandler
{
    /**
     * Must be defined by child
     * @var string
     */
    protected $method;

    /** @var CatchAllRenderer */
    private $renderer;

    /** @var StatusCodeMatcher */
    private $codeMatcher;

    /**
     * @param CatchAllRenderer  $renderer
     * @param StatusCodeMatcher $codeMatcher
     */
    public function __construct(
        CatchAllRenderer $renderer,
        StatusCodeMatcher $codeMatcher
    ) {
        $this->renderer    = $renderer;
        $this->codeMatcher = $codeMatcher;
    }

    public function handle(Request $request, Throwable $e)
    {
        $code = $this->codeMatcher->match($e);
        return $this->renderer->render($e, $code, $this->method);
    }
}
