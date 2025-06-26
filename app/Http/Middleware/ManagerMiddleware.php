<?php

    namespace App\Http\Middleware;

    use Closure;
    use Illuminate\Http\Request;
    use Symfony\Component\HttpFoundation\Response;

    class ManagerMiddleware
    {
        /**
         * Handle an incoming request.
         *
         * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
         */
        public function handle(Request $request, Closure $next): Response
        {
            // Izinkan akses jika pengguna adalah 'manager' atau 'admin'
            if (auth()->check() && (auth()->user()->role === 'manager' || auth()->user()->role === 'admin')) {
                return $next($request);
            }

            // Jika bukan, tolak akses
            abort(403, 'AKSES DITOLAK. ANDA BUKAN MANAJER ATAU ADMIN.');
        }
    }