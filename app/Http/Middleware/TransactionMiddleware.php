<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class TransactionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        DB::beginTransaction(); // Start a database transaction

        try {
            $response = $next($request); // Handle the request

            DB::commit(); // Commit the transaction

            return $response;
        } catch (\Exception $e) {
            DB::rollBack(); // Roll back the transaction in case of an exception
            throw $e; // Re-throw the exception
        }
    }
}
