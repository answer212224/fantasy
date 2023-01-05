<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MemberAuth
{
    public function handle(Request $request, Closure $next)
    {
        if(!session()->has('member_id')){
            return redirect(env('APP_URL') . '/');
        };
        return $next($request);

    }
}
