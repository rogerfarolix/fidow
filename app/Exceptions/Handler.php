<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        // Si la requête attend du JSON (API calls), retourner toujours du JSON
        if ($request->expectsJson() || $request->is('api/*') || $request->routeIs('generer')) {
            return $this->renderJsonException($exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * Render exception as JSON response
     */
    protected function renderJsonException(Throwable $exception): JsonResponse
    {
        $status = 500;
        $message = 'Erreur serveur interne';

        // Validation errors
        if ($exception instanceof ValidationException) {
            $status = 422;
            return response()->json([
                'error' => 'Erreur de validation',
                'messages' => $exception->errors()
            ], $status);
        }

        // HTTP exceptions
        if (method_exists($exception, 'getStatusCode')) {
            $status = $exception->getStatusCode();
            $message = $exception->getMessage() ?: $this->getHttpMessage($status);
        }

        // Database connection errors
        if (str_contains($exception->getMessage(), 'SQLSTATE') || 
            str_contains($exception->getMessage(), 'Connection')) {
            $message = 'Erreur de base de données temporaire';
        }

        // Log l'erreur complète pour le debugging
        \Log::error('JSON Exception Response', [
            'message' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
            'status' => $status
        ]);

        return response()->json([
            'error' => $message
        ], $status);
    }

    /**
     * Get HTTP status message
     */
    protected function getHttpMessage(int $status): string
    {
        return match($status) {
            400 => 'Requête invalide',
            401 => 'Non autorisé',
            403 => 'Accès interdit',
            404 => 'Ressource non trouvée',
            405 => 'Méthode non autorisée',
            422 => 'Erreur de validation',
            429 => 'Trop de requêtes',
            500 => 'Erreur serveur interne',
            502 => 'Service indisponible',
            503 => 'Service temporairement indisponible',
            default => 'Erreur serveur'
        };
    }
}
