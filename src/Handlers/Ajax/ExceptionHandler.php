<?php

namespace ElleTheDev\Glove\Handlers\Ajax;

use ElleTheDev\Glove\Contracts\Handler;
use ElleTheDev\Glove\Handlers\AbstractExceptionHandler;

/**
 * General AJAX Exception Handler
 *
 * Any otherwise uncaught AJAX exceptions will end up here.
 */
class ExceptionHandler extends AbstractExceptionHandler implements Handler
{
    protected $method = 'ajax';
}
