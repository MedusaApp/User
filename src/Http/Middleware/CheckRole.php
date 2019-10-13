<?php
namespace Personality\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;

class CheckRole
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (!$request->user() || $request->user()->isNotA($role)) {
            return Redirect::route('not.authorized');
        }

        return $next($request);
    }

}