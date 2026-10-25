<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'برای دسترسی به این بخش، لطفاً وارد شوید.');
        }

        if (!Auth::user()->is_admin) {
            abort(403, 'شما دسترسی به این بخش ندارید.');
        }

        return $next($request);
    }
}