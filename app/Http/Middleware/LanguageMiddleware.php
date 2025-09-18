<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!session()->has('locale')){
            session()->put('locale', config('app.locale'));
        }

        if(session()->has('order_date') && session()->has('failed_order')){
            session()->forget('order_date');
        }

        app()->setLocale(session('locale'));
        

        return $next($request);
    }
}
