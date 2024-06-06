<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::user() || !Auth::user()->subscribed('default')) {
            return redirect()->route('pricing')->with('error', 'You need to be subscribed to access this page.');
        }

        return $next($request);
    }
}
