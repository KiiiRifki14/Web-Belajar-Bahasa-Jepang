<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SecretNote;
use Illuminate\Http\Request;

class SecretNoteController extends Controller
{
    public function index()
    {
        $notes = SecretNote::latest()->get();
        return view('admin.secret_notes.index', compact('notes'));
    }

    public function create()
    {
        return view('admin.secret_notes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'category' => 'required|string',
            'is_active' => 'boolean',
        ]);

        SecretNote::create($validated);
        return redirect()->route('admin.secret_notes.index')->with('success', 'Secret note added.');
    }

    public function edit(SecretNote $secretNote)
    {
        return view('admin.secret_notes.edit', compact('secretNote'));
    }

    public function update(Request $request, SecretNote $secretNote)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'category' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $secretNote->update($validated);
        return redirect()->route('admin.secret_notes.index')->with('success', 'Secret note updated.');
    }

    public function destroy(SecretNote $secretNote)
    {
        $secretNote->delete();
        return redirect()->route('admin.secret_notes.index')->with('success', 'Secret note deleted.');
    }
}
