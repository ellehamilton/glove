Laravel Glove
---------------

Catch exceptions with Laravel Glove.

### Requirements ###

Laravel Glove is written for Laravel 5.5 and higher, thus also requiring PHP 7.0 and higher.

### Installation ###

Installation is done via composer

`composer require derekhamilton/laravel-glove`

Once installed we need to run

`php artisan vendor:publish`

in order to install the required configuration files.

The service provider is

`DerekHamilton\\Glove\\Providers\\GloveServiceProvider`

But should be autodiscovered.

### Error Pages ###

We can easily customize our error pages by updating `config/glove-codes.php`

#### Basic Example ####

Let's send all 404 status codes to our `errors.404` view.

~~~php
...

'404' => [
    'view' => 'errors.404'
]

...
~~~

#### Error Pages with Data ####

Additional data can be passed to our view to assist with reusing views for multiple status codes.

~~~php
...

'404' => [
    'view' => 'errors.404',
    'data' => [
        'foo' => 'bar'
    ]
]

...
~~~

### HTTP Status Codes ###

We can specify which status to code for which exceptions in `config/glove.php'

Let's make `MyException` emit a `403` status

~~~php
'statusCodes' => [
    ...

    \App\Exception\MyException::class => '403',

    ...
]
~~~

### Logging ###

Whether or not to log exceptions, and the log level at which to log them, can be specified in `config/glove.php`

#### Skipping Logging ####

We can ignore logging on an exception by setting the log level to `ignore`

~~~php
'logLevels' => [
    ...

    \App\Exceptions\MyException::class => 'critical',

    ...
]
~~~

#### Changing the Log Level ####

We can change the log level from the default 'error' to any of the Laravel log levels.

~~~php
'logLevels' => [
    \App\Exceptions\MyException::class => 'critical'
]
~~~

### Custom Exception Handling ###

Writing a custom exception handler is as simple as implementing the `Handler` interface then telling it when to run in `config/glove.php`

#### Custom Response ####

To send back a customized response, return a response from the `handle` method.

Let's say have a custom exception, `MyException`

~~~php
namespace App\Exceptions;

class MyException extends \Exception
{
}
~~~

We'll write a custom handler to handle that exception.

~~~php
namespace App\Exceptions\Handlers;

use DerekHamilton\Glove\Contracts\Handler;

class MyHandler implements Handler
{
    public function handle(Request $request, Exception $e)
    {
        return response(json_encode(['foo' => 'bar']))
            ->header('Content-Type', 'application/json');
    }
}
~~~

Once `MyHandler` exists, we can add it to `config/glove.php`

If we only want it to run if it's an AJAX request, we can add it to the `ajax` section of `handlers`

~~~php
'handlers' => [
    ...

    'ajax' => [
        ...
        \App\Exceptions\MyException::class => [
            \App\Exceptions\Handlers\MyHandler::class
        ]
    ]

    ...
],
~~~

An exception can have multiple handlers, as if `null` is returned instead of a `Response` object, it will cascade and continue processing handlers until it does receive a response.

#### Custom Handler Without a Response ####

If we want our handler to do something, but let other handlers deal with how to respond, we can simply omit a return value or return null in order to cascade.

~~~php
namespace App\Exceptions\Handlers;

use DerekHamilton\Glove\Contracts\Handler;

class MyHandler implements Handler
{
    public function handle(Request $request, Exception $e)
    {
        \Log::info("Something happened!");
    }
}
~~~

