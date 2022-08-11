<?php
namespace ElleHamilton\Glove\Handlers;

use ElleHamilton\Glove\Http\StatusCodeMatcher;
use ElleHamilton\Glove\Renderers\CatchAllRenderer;
use Exception;
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

    public function handle(Request $request, Exception $e)
    {
        $code = $this->codeMatcher->match($e);
        return $this->renderer->render($e, $code, $this->method);
    }
}
