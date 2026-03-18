<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        // 检查用户是否已登录
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 检查用户角色是否为 admin
        if (Auth::user()->role !== 'admin') {
            abort(403, '您没有权限访问此页面');
        }

        return $next($request);
    }
}
