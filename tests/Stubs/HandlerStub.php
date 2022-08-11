<?php
namespace ElleHamilton\Tests\Glove\Stubs;

use Illuminate\Http\Request;
use ElleHamilton\Glove\Contracts\Handler;
use Exception;

class HandlerStub implements Handler
{
    public function handle(Request $request, Exception $e)
    {
        return response("success");
    }
}
