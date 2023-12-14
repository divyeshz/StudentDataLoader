<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use App\Traits\JsonResponseTrait;

class Authenticate extends Middleware
{
    use JsonResponseTrait;
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function unauthenticated($request, array $guards)
    {
        abort($this->error(403, 'Unauthorized!!!'));
    }
}
