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
        $locale = session('locale', config('app.locale'));

        app()->setLocale($locale);   
        
        // $request->route()->setAction(array_merge(
        //     $request->route()->getAction(),
        //     ['prefix' => $locale]
        // ));

        return $next($request);
    }
}
