<?php
namespace DerekHamilton\Glove\Handlers;

use DerekHamilton\Glove\Contracts\Handler;
use Illuminate\Http\Request;
use DerekHamilton\Glove\Renderers\CatchAllRenderer;
use DerekHamilton\Glove\Http\StatusCodeMatcher;
use Exception;

/**
 * General Exception Handler
 *
 * Any otherwise uncaught exceptions will end up here.
 */
class ExceptionHandler implements Handler
{
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
        $this->renderer = $renderer;
        $this->codeMatcher = $codeMatcher;
    }

    public function handle(Request $request, Exception $e)
    {
        $code = $this->codeMatcher->match($e);
        return $this->renderer->render($e, $code);
    }
}
