<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    public function handle($request, Closure $next)
    {
        $allowedOrigins = ['http://localhost:5173'];  // Add your allowed origins here
        $origin = $request->headers->get('Origin');

        if (in_array($origin, $allowedOrigins)) {
            $response = $next($request);
            $response->headers->set('Access-Control-Allow-Origin', $origin);
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');
            $response->headers->set('Access-Control-Allow-Credentials', 'true');

            if ($request->getMethod() == "OPTIONS") {
                return response('', 200)
                    ->header('Access-Control-Allow-Origin', $origin)
                    ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                    ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization')
                    ->header('Access-Control-Allow-Credentials', 'true');
            }

            return $response;
        }

        return $next($request);
    }
}
