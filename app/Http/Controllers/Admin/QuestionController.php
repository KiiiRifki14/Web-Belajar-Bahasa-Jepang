<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Question;
use App\Models\Level;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with('level.region')->orderBy('level_id')->get();
        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        $levels = Level::with('region')->orderBy('region_id')->orderBy('order')->get();
        return view('admin.questions.create', compact('levels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'level_id' => 'required|exists:levels,id',
            'type' => 'required|in:multiple_choice,fill_in',
            'question_text' => 'required|string',
            'visual_hint' => 'nullable|image|max:2048',
            'options' => 'nullable|array',
            'correct_answer' => 'required|string|max:255',
            'explanation' => 'nullable|string',
        ]);

        if ($request->hasFile('visual_hint')) {
            $validated['visual_hint_path'] = $request->file('visual_hint')->store('questions', 'public');
        }

        Question::create($validated);
        return redirect()->route('admin.questions.index')->with('success', 'Question added successfully.');
    }

    public function show(Question $question)
    {
        return view('admin.questions.show', compact('question'));
    }

    public function edit(Question $question)
    {
        $levels = Level::with('region')->orderBy('region_id')->orderBy('order')->get();
        return view('admin.questions.edit', compact('question', 'levels'));
    }

    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'level_id' => 'required|exists:levels,id',
            'type' => 'required|in:multiple_choice,fill_in',
            'question_text' => 'required|string',
            'visual_hint' => 'nullable|image|max:2048',
            'options' => 'nullable|array',
            'correct_answer' => 'required|string|max:255',
            'explanation' => 'nullable|string',
        ]);

        if ($request->hasFile('visual_hint')) {
            if ($question->visual_hint_path) {
                Storage::disk('public')->delete($question->visual_hint_path);
            }
            $validated['visual_hint_path'] = $request->file('visual_hint')->store('questions', 'public');
        }

        $question->update($validated);
        return redirect()->route('admin.questions.index')->with('success', 'Question updated successfully.');
    }

    public function destroy(Question $question)
    {
        if ($question->visual_hint_path) {
            Storage::disk('public')->delete($question->visual_hint_path);
        }
        $question->delete();
        return redirect()->route('admin.questions.index')->with('success', 'Question deleted successfully.');
    }
}
