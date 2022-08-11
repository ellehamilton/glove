<?php
namespace ElleHamilton\Glove\Handlers\Ajax;

use ElleHamilton\Glove\Contracts\Handler;
use ElleHamilton\Glove\Handlers\AbstractExceptionHandler;

/**
 * General AJAX Exception Handler
 *
 * Any otherwise uncaught AJAX exceptions will end up here.
 */
class ExceptionHandler extends AbstractExceptionHandler implements Handler
{
    protected $method = 'ajax';
}
