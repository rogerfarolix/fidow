<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DynamicAIService;
use App\Models\LlmConfiguration;

class LlmController extends Controller
{
    private $aiService;

    public function __construct(DynamicAIService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Affiche le dashboard de gestion des LLM
     */
    public function index()
    {
        $stats = $this->aiService->getUsageStats();
        $connections = $this->aiService->testConnections();
        
        return view('admin.llm.index', compact('stats', 'connections'));
    }

    /**
     * Affiche les détails d'un provider
     */
    public function show($provider)
    {
        $llmConfig = LlmConfiguration::where('provider', $provider)->firstOrFail();
        $stats = $this->aiService->getUsageStats();
        
        return view('admin.llm.show', compact('llmConfig', 'stats'));
    }

    /**
     * Met à jour la configuration d'un provider
     */
    public function update(Request $request, $provider)
    {
        $llmConfig = LlmConfiguration::where('provider', $provider)->firstOrFail();
        
        $validated = $request->validate([
            'display_name' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'is_active' => 'boolean',
            'max_tokens' => 'required|integer|min:1|max:8192',
            'temperature' => 'required|numeric|min:0|max:2',
            'timeout_seconds' => 'required|integer|min:5|max:120',
        ]);

        $llmConfig->update($validated);

        return redirect()->route('admin.llm.show', $provider)
            ->with('success', 'Configuration mise à jour avec succès');
    }

    /**
     * Définit un provider comme principal
     */
    public function setPrimary($provider)
    {
        $success = $this->aiService->setPrimaryProvider($provider);
        
        if ($success) {
            return redirect()->route('admin.llm.index')
                ->with('success', "Provider {$provider} défini comme principal");
        }

        return redirect()->route('admin.llm.index')
            ->with('error', 'Impossible de définir ce provider comme principal');
    }

    /**
     * Met à jour l'ordre des providers
     */
    public function updateOrder(Request $request)
    {
        $orderedProviders = $request->input('providers', []);
        
        if (empty($orderedProviders)) {
            return response()->json(['success' => false, 'message' => 'Aucun provider fourni']);
        }

        $success = $this->aiService->updateProviderOrder($orderedProviders);
        
        return response()->json([
            'success' => $success,
            'message' => $success ? 'Ordre mis à jour avec succès' : 'Erreur lors de la mise à jour'
        ]);
    }

    /**
     * Active/désactive un provider
     */
    public function toggleStatus(Request $request, $provider)
    {
        $llmConfig = LlmConfiguration::where('provider', $provider)->firstOrFail();
        
        $llmConfig->update([
            'is_active' => $request->boolean('is_active')
        ]);

        return response()->json([
            'success' => true,
            'message' => $llmConfig->is_active ? 'Provider activé' : 'Provider désactivé'
        ]);
    }

    /**
     * Test la connexion d'un provider spécifique
     */
    public function testProvider($provider)
    {
        $llmConfig = LlmConfiguration::where('provider', $provider)->firstOrFail();
        
        if (!$llmConfig->hasApiKey()) {
            return response()->json([
                'success' => false,
                'error' => 'Clé API non configurée'
            ]);
        }

        $result = $this->aiService->callProvider(
            $llmConfig, 
            'Test message - respond with {"status":"ok","provider":"' . $provider . '"}', 
            ['max_tokens' => 50]
        );

        if ($result['success']) {
            $llmConfig->recordUsage(true);
        } else {
            $llmConfig->recordUsage(false, $result['error']);
        }

        return response()->json($result);
    }

    /**
     * Test toutes les connexions
     */
    public function testAllConnections()
    {
        $connections = $this->aiService->testConnections();
        
        return response()->json([
            'success' => true,
            'connections' => $connections
        ]);
    }

    /**
     * Réinitialise les statistiques d'un provider
     */
    public function resetStats($provider)
    {
        $llmConfig = LlmConfiguration::where('provider', $provider)->firstOrFail();
        
        $llmConfig->update([
            'usage_count' => 0,
            'success_count' => 0,
            'failure_count' => 0,
            'last_error' => null,
            'last_error_at' => null,
            'last_used_at' => null,
        ]);

        return redirect()->route('admin.llm.show', $provider)
            ->with('success', 'Statistiques réinitialisées avec succès');
    }

    /**
     * API pour obtenir les statistiques en temps réel
     */
    public function apiStats()
    {
        $stats = $this->aiService->getUsageStats();
        
        return response()->json($stats);
    }

    /**
     * API pour tester un provider spécifique
     */
    public function apiTestProvider($provider)
    {
        $result = $this->testProvider($provider);
        return $result;
    }
}
