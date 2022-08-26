<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
// use App\Models\User;
use Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $role  = Auth::user()->roles()->first()->name;
                switch ($role){
                    case 'renter' : return redirect()->route('renter.product-orders.all');
                    case 'manager' : return redirect()->route('manager.support');
                    case 'admin' : return redirect()->route('adminProducts');
                    case 'collector' :
                        $loginAt = date('Y-m-d H:i:s');
                        $collector = Auth::user();
                        $collector->update(['last_login' => $loginAt, 'collector_online' => 1]);
                        return redirect()->route('collectorOrders');
                    break;
                    case 'courier' : return redirect()->route('courierOrders');
                }
            }
        }

        return $next($request);
    }
}
