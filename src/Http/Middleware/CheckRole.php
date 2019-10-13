<?php
namespace Personality\Http\Middleware;

use Closure;

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
        if ($request->user()->isNotA($role)) {
            return Redirect::route('not.authorized');
        }

        return $next($request);
    }

}