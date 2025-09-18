<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class InnoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!session()->has('innolangs')){
            $langs = \App\Models\Language::get();
            session()->put('innolangs', $langs);
        }

        if(!session()->has('innolang')){
            session()->put('innolang', config('app.inno_lang'));
        } 
        
        app()->setLocale(session('innolang'));

        return $next($request);
    }
}
