<?php
namespace DerekHamilton\Glove\Contracts;

use Illuminate\Http\Request;
use Exception;

interface Handler
{
    /**
     * @param Request   $request
     * @param Exception $e
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function handle(Request $request, Exception $e);
}
