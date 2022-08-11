<?php

namespace ElleHamilton\Glove\Renderers;

use Throwable;
use Illuminate\Routing\ResponseFactory;

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
     * @param Throwable $e
     * @return \Illuminate\Http\Response
     */
    public function render(Throwable $e)
    {
        return $this->factory->make($e);
    }
}
