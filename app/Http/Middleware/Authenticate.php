<?php

namespace App\Http\Middleware;

use App\Traits\Respondable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    use Respondable;

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @return bool|string|null
     * @throws AuthenticationException
     */
    protected function redirectTo($request): bool|string|null
    {
        if (! $request->expectsJson()) {
            throw new AuthenticationException();
        }
        return true;
    }
}
