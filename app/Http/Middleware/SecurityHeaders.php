<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // N'appliquer les en-têtes qu'aux réponses qui le supportent
        if (method_exists($response, 'headers')) {
            $response->headers->set('X-Frame-Options', 'DENY');
            $response->headers->set('X-XSS-Protection', '1; mode=block');
            $response->headers->set('X-Content-Type-Options', 'nosniff');
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
            $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
            
            // Note: Une CSP stricte (Content-Security-Policy) pourrait casser des scripts inline (comme Vite).
            // Si nécessaire, on peut l'ajouter ici plus tard après tests.
        }

        return $response;
    }
}
