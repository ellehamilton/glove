<?php
namespace DerekHamilton\Glove\Renderers;

use Illuminate\Routing\ResponseFactory;
use Exception;

/**
 * Fallback renderer of simple text output
 */
class SimpleExceptionRenderer
{
    /** @var ResponseFactory */
    private $factory;

    /**
     * @param ResponseFactory $factory
     */
    public function __construct(ResponseFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render(Exception $e)
    {
        return $this->factory->make($e);
    }
}
