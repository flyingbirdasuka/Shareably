<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Localization
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
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        } else {
            $browserLanguage = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2); //read browser language
            if(in_array($browserLanguage, config('app.available_locales'))){
                App::setLocale('locale', $browserLanguage);
            } else {
                App::setLocale('locale', 'en');
            }
        }

        return $next($request);
    }
}