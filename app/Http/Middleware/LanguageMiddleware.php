<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $lang = null): Response
    {        

        if ($lang && in_array($lang, config('app.available_locales'))) {
            App::setLocale($lang);
        } else {
            App::setLocale(config('app.locale')); // fallback
        }

        return $next($request);
    }
}
