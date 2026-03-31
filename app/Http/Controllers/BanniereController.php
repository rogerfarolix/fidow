<?php
// app/Http/Controllers/BanniereController.php

namespace App\Http\Controllers;

use App\Models\PromptTemplate;
use App\Models\ToolUsage;
use Illuminate\Http\Request;

class BanniereController extends Controller
{
    public function index()
    {
        $templates = PromptTemplate::actif()->type('banniere')->get();

        return view('banniere.index', compact('templates'));
    }

    public function compiler(Request $request, string $id)
    {
        $template = PromptTemplate::findOrFail($id);

        $request->validate([
            'variables'   => 'nullable|array',
            'variables.*' => 'nullable|string|max:300',
        ]);

        // Tracking
        ToolUsage::create([
            'tool_slug'  => 'banniere',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $compiled = $template->compilePrompt($request->input('variables', []));

        return response()->json([
            'prompt'  => $compiled,
            'titre'   => $template->titre,
        ]);
    }
}
