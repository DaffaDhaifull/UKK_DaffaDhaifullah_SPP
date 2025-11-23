<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                if ($guard === 'petugas') {
                    $user = Auth::guard('petugas')->user();

                    if ($user->level === 'admin') {
                        return redirect()->route('beranda.admin');
                    }

                    if ($user->level === 'petugas') {
                        return redirect()->route('beranda.petugas');
                    }
                }

                if ($guard === 'siswa') {
                    return redirect()->route('beranda.siswa',Auth::guard('siswa')->user()->nisn);
                }
            }
        }

        return $next($request);
    }
}
