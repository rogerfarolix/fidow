<?php
// app/Http/Controllers/AdminPromptController.php

namespace App\Http\Controllers;

use App\Models\PromptTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPromptController extends Controller
{
    public function index()
    {
        $templates = PromptTemplate::orderBy('type')->orderBy('ordre')->get();
        return view('admin.prompts.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.prompts.form', ['template' => null]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('prompts', 'public');
        }

        PromptTemplate::create($data);

        return redirect()->route('admin.prompts')->with('success', 'Prompt créé avec succès.');
    }

    public function edit(string $id)
    {
        $template = PromptTemplate::findOrFail($id);
        return view('admin.prompts.form', compact('template'));
    }

    public function update(Request $request, string $id)
    {
        $template = PromptTemplate::findOrFail($id);
        $data     = $this->validateData($request);

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($template->image_path) {
                Storage::disk('public')->delete($template->image_path);
            }
            $data['image_path'] = $request->file('image')->store('prompts', 'public');
        }

        if ($request->boolean('remove_image') && $template->image_path) {
            Storage::disk('public')->delete($template->image_path);
            $data['image_path'] = null;
        }

        $template->update($data);

        return redirect()->route('admin.prompts')->with('success', 'Prompt mis à jour.');
    }

    public function destroy(string $id)
    {
        $template = PromptTemplate::findOrFail($id);
        if ($template->image_path) {
            Storage::disk('public')->delete($template->image_path);
        }
        $template->delete();

        return redirect()->route('admin.prompts')->with('success', 'Prompt supprimé.');
    }

    private function validateData(Request $request): array
    {
        $validated = $request->validate([
            'type'        => 'required|in:profil,banniere',
            'titre'       => 'required|string|max:120',
            'sous_titre'  => 'nullable|string|max:200',
            'description' => 'nullable|string|max:1000',
            'prompt_body' => 'required|string',
            'variables'   => 'nullable|string', // JSON encodé depuis le textarea
            'plateforme'  => 'nullable|string|max:80',
            'dimensions'  => 'nullable|string|max:80',
            'ordre'       => 'nullable|integer|min:0|max:255',
            'actif'       => 'nullable|boolean',
            'image'       => 'nullable|image|mimes:jpeg,png,webp,gif|max:3072',
        ]);

        // Parser le champ variables (tableau JSON ou liste)
        if (!empty($validated['variables'])) {
            $decoded = json_decode($validated['variables'], true);
            $validated['variables'] = is_array($decoded) ? $decoded : array_filter(array_map('trim', explode(',', $validated['variables'])));
        } else {
            $validated['variables'] = null;
        }

        $validated['actif'] = $request->boolean('actif', true);
        $validated['ordre'] = (int)($validated['ordre'] ?? 0);

        return $validated;
    }
}
