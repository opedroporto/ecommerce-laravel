<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || auth()->user()->role != 1) {
            // return redirect()->back()->with(["login_needed" => true, "login_msg" => "É necessário fazer login para realizar essa ação."]);
            return redirect()->route("site.index")->with(["login_needed" => true, "login_msg" => "É necessário fazer login para realizar essa ação."]);
        }
        return $next($request);
    }
}
