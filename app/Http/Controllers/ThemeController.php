<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThemeController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'theme' => 'required|string|in:senja,perpustakaan,neon'
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->active_theme = $request->theme;
        $user->save();

        return back()->with('success', 'Theme updated to ' . ucfirst($request->theme) . '!');
    }
}
