<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
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
        $response = $next($request);

        // CSPポリシーを設定
        $response->headers->set('Content-Security-Policy', "script-src 'self' 'unsafe-eval' 'wasm-unsafe-eval' chrome-extension://cc0a5c6b-3e02-45e4-bd21-b81889231c39;");

        return $next($request);
    }
}
