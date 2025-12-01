<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRolePemilik
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->role === 'pemilik') {
            return $next($request);
        }

        return redirect('/login')->with('error', 'Hanya pemilik yang bisa akses halaman ini');
    }
}
