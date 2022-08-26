<?php

namespace App\Http\Middleware;

use App\Http\Services\TimeIntervalService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Customer
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

        if(Auth::check() and Auth::user()->roles->first()->name!= "customer"){
            Auth::logout();
        }
        TimeIntervalService::prepareCookies();
        return $next($request);
    }

}
