<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceApiResponse
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Forcer l'en-tête Accept pour JSON
        $request->headers->set('Accept', 'application/json');
        
        $response = $next($request);
        
        // Si la réponse n'est pas en JSON et que c'est une erreur, la convertir
        if (!$response->isSuccessful() && !$request->expectsJson()) {
            if ($response->headers->get('content-type') && 
                str_contains($response->headers->get('content-type'), 'text/html')) {
                
                // Extraire le message d'erreur du HTML si possible
                $content = $response->getContent();
                $error = 'Erreur serveur interne';
                
                if (preg_match('/<title>(.*?)<\/title>/i', $content, $matches)) {
                    $error = strip_tags($matches[1]);
                }
                
                return response()->json(['error' => $error], $response->getStatusCode());
            }
        }
        
        return $response;
    }
}
