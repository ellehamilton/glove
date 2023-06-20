<?php

namespace ElleTheDev\Glove\Handlers;

use ElleTheDev\Glove\Contracts\Handler;

/**
 * General Exception Handler
 *
 * Any otherwise uncaught exceptions will end up here.
 */
class ExceptionHandler extends AbstractExceptionHandler implements Handler
{
    protected $method = 'http';
}
