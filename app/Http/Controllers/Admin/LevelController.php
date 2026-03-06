<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Level;
use App\Models\Region;

class LevelController extends Controller
{
    public function index()
    {
        $levels = Level::with('region')->orderBy('region_id')->orderBy('order')->get();
        return view('admin.levels.index', compact('levels'));
    }

    public function create()
    {
        $regions = Region::orderBy('order')->get();
        return view('admin.levels.create', compact('regions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'region_id' => 'required|exists:regions,id',
            'name' => 'required|string|max:255',
            'order' => 'required|integer',
            'is_boss_level' => 'boolean',
            'required_streak' => 'required|integer|min:0',
        ]);

        Level::create($validated);
        return redirect()->route('admin.levels.index')->with('success', 'Level created successfully.');
    }

    public function show(Level $level)
    {
        return view('admin.levels.show', compact('level'));
    }

    public function edit(Level $level)
    {
        $regions = Region::orderBy('order')->get();
        return view('admin.levels.edit', compact('level', 'regions'));
    }

    public function update(Request $request, Level $level)
    {
        $validated = $request->validate([
            'region_id' => 'required|exists:regions,id',
            'name' => 'required|string|max:255',
            'order' => 'required|integer',
            'is_boss_level' => 'boolean',
            'required_streak' => 'required|integer|min:0',
        ]);

        $level->update($validated);
        return redirect()->route('admin.levels.index')->with('success', 'Level updated successfully.');
    }

    public function destroy(Level $level)
    {
        $level->delete();
        return redirect()->route('admin.levels.index')->with('success', 'Level deleted successfully.');
    }
}
