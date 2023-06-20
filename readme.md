Laravel Glove
---------------

Catch exceptions with Laravel Glove. The main goal of this package is to make it as easy as possible to add custom error pages and create custom error handlers to do whatever we need.

This means

 - [Custom error pages](#error-pages) that don't need a handler - just point to the view in the config
 - [Status codes](#http-status-codes) and [log levels](#logging) specified in the config
 - [Simple interface](#custom-exception-handling) to implement that lets us return a response and be done
 - [Cascading handlers](#custom-handler-without-a-response) simply by omitting a response

### Requirements ###

Laravel Glove is written for Laravel 5.5 and higher, thus also requiring PHP 7.0 and higher.

### Installation ###

Installation is done via composer

~~~shell
composer require ellehamilton/glove
~~~

Once installed we need to run

~~~shell
php artisan vendor:publish
~~~

If we don't use auto-discovery, we'll need to add `GloveServiceProvider` to the providers array in `config/app.php`

~~~php
ElleTheDev\Glove\Providers\GloveServiceProvider::class,
~~~

Glove integrates automatically with [Whoops](https://github.com/filp/whoops) with no additional configuration.

### Error Pages ###

We can easily customize our error pages by updating `config/glove-codes.php`

#### Basic Example ####

Let's send all 404 status codes to our `errors.404` view.

~~~php
...

404 => [
    'view' => [
        'http' => 'errors.404',
        'ajax' => 'vendor.glove.ajax.exception'
    ]
]

...
~~~

#### Error Pages with Data ####

Additional data can be passed to our view to assist with reusing views for multiple status codes.

~~~php
...

404 => [
    'view' => [
        'http' => 'errors.404',
        'ajax' => 'vendor.glove.ajax.exception'
    ],
    'data' => [
        'foo' => 'bar'
    ]
]

...
~~~

If we want our view to show up as a page regardless of debug settings, we can set the debug override to false so that, for example, 404 pages always appear as such instead of showing a Whoops debug page.

~~~php
...

404 => [
    'view' => [
        'http' => 'errors.404',
        'ajax' => 'vendor.glove.ajax.exception'
    ],
    'debug' => false
]

...
~~~

`debug` defaults to `true` when absent.

By changing the `ajax` view, we can use our own custom AJAX format. By default, the provided view will result in the format of

~~~javascript
{ error: { code: 404, message: "404 Page Not Found. The address you were looking for does not exist." } }
~~~

### HTTP Status Codes ###

We can specify which status to code for which exceptions in `config/glove.php`

Let's make `MyException` emit a `403` status

~~~php
'statusCodes' => [
    ...

    \App\Exceptions\MyException::class => 403,

    ...
]
~~~

Status codes are interpreted in order from top to bottom. The first exception it finds that is an instance of the exception thrown will be the status code used.

e.g if we have the following,

~~~php
'statusCodes' => [
    \App\Exceptions\MyException::class => 403,
    \Exception::class => 500,
];
~~~

If we throw `\App\Exceptions\MyException` the status code will be `403` because it matches and is first. If we reverse the order,

~~~php
'statusCodes' => [
    \Exception::class => 500,
    \App\Exceptions\MyException::class => 403,
];
~~~

Then the status code will be `500` because `\App\Exceptions\MyException` is an instance of `Exception` and is matched first.

`\Symfony\Component\HttpKernel\Exception\HttpException` is a special case. When using `abort(403)` or a variant thereof, excluding the case of a `404` status code, will result in a `HttpException` with the status code contained within. Glove handles this case automatically, and interprets an `HttpException` as whatever status code it contains, so it does not need to be included in the status codes configuration unless we wish to override its handling.

### Logging ###

Whether or not to log exceptions, and the log level at which to log them, can be specified in `config/glove.php`

Logging is also considered in top-to-bottom order in the same manner as Status Codes.

#### Skipping Logging ####

We can ignore logging on an exception by setting the log level to `ignore`

~~~php
'logLevels' => [
    ...

    \App\Exceptions\MyException::class => 'ignore',

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

Writing a custom exception handler is as simple as implementing the `\ElleTheDev\Glove\Contracts\Handler` then telling it when to run in `config/glove.php`

There's only one function to implement.

~~~php
public function handle(\Illuminate\Http\Request $request, \Exception $e);
~~~

#### Custom Response ####

To send back a customized response, return a response from the `handle` method.

Let's say we have a custom exception, `MyException`

~~~php
namespace App\Exceptions;

class MyException extends \Exception
{
}
~~~

We'll write a custom handler to handle that exception.

~~~php
namespace App\Exceptions\Handlers;

use ElleTheDev\Glove\Contracts\Handler;
use Illuminate\Http\Request;
use Exception;

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
        ],

        ...
    ]

    ...
],
~~~

An exception can have multiple handlers, as if `null` is returned instead of a `Response` object, it will cascade and continue processing handlers until it does receive a response.

Handlers are interpreted in top-to-bottom order in the same manner as Status Codes.

#### Custom Handler Without a Response ####

If we want our handler to do something, but let other handlers deal with how to respond, we can simply omit a return value or return null in order to cascade.

~~~php
namespace App\Exceptions\Handlers;

use ElleTheDev\Glove\Contracts\Handler;

class MyHandler implements Handler
{
    public function handle(Request $request, Exception $e)
    {
        \Log::info("Something happened!");
    }
}
~~~
