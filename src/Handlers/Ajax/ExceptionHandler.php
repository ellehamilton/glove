<?php
namespace DerekHamilton\Glove\Handlers\Ajax;

use DerekHamilton\Glove\Contracts\Handler;
use DerekHamilton\Glove\Handlers\AbstractExceptionHandler;

/**
 * General AJAX Exception Handler
 *
 * Any otherwise uncaught AJAX exceptions will end up here.
 */
class ExceptionHandler extends AbstractExceptionHandler implements Handler
{
    protected $method = 'ajax';
}
