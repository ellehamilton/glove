<?php

return [

    // By default, Glove overrides the exception handler class in order
    // to take over handling. If your project has exception handling in
    // a different location, then this can be changed to accomodate.
    'appHandler' => \App\Exceptions\Handler::class,

    // Register any exception handlers in this array
    'handlers' => [
        // AJAX handlers are only processed if the request is an AJAX request
        'ajax' => [
            Exception::class => [
                \ElleTheDev\Glove\Handlers\WhoopsHandler::class,
                \ElleTheDev\Glove\Handlers\Ajax\ExceptionHandler::class,
            ]
        ],

        // HTTP handlers are for any requests that are not AJAX requests
        'http' => [
        ],

        // Global handlers apply regardless of the request type.
        // They are processed last, so if another handler matches and responds
        // first, the global handler will not be reached.
        'global' => [
            Exception::class => [
                \ElleTheDev\Glove\Handlers\WhoopsHandler::class,
                \ElleTheDev\Glove\Handlers\ExceptionHandler::class,
            ]
        ]
    ],

    // Exceptions to pass directly through glove and do not catch
    'dontReport' => [
    ],

    // Laravel logs based on log levels.
    // You only need to specify a log level if you want to override the default
    // for a particular exception from the Exception level.
    //
    // If you do not want a particular exception logged, specify the level as 'ignore'
    'logLevels' => [
        Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class => 'ignore',
        Exception::class => 'error'
    ],

    // Which HTTP status code to send back for a given exception is defined here
    'statusCodes' => [
        Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class => 404,
        Exception::class => 500
    ]

];
