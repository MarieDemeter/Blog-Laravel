<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Auth;
use Closure;
use Illuminate\Http\Request;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        //$user = Auth::user()->is_admin;
        if ($user->is_admin == 0) {
            return redirect()->intended(RouteServiceProvider::HOME);
        } else {
            return $next($request);
        }
    }
}
