<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRolePencari
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->role === 'pencari') {
            return $next($request);
        }

        return redirect('/login')->with('error', 'Hanya pencari yang bisa akses halaman ini');
    }
}
