<?php

namespace App\Http\Middleware;

use App\Http\Modules\BaseResponseErrors;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    use BaseResponseErrors;

    public function handle($request, Closure $next, ...$guards)
    {
        if(!auth()->check())
            return $this->e401();

        return $next($request);
    }
}
