<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class Language
{
    protected $languages = ['en','zh_cn'];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Session::has('lang'))
        {
            Session::put('lang', $request->getPreferredLanguage($this->languages));
        }
        app()->setLocale(Session::get('lang'));
        return $next($request);
    }
}
