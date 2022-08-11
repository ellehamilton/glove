<?php
namespace ElleHamilton\Glove\Handlers;

use ElleHamilton\Glove\Contracts\Handler;

/**
 * General Exception Handler
 *
 * Any otherwise uncaught exceptions will end up here.
 */
class ExceptionHandler extends AbstractExceptionHandler implements Handler
{
    protected $method = 'http';
}
