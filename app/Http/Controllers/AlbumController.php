<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MemoryAlbum;
use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
{
    public function index()
    {
        $memories = MemoryAlbum::where('user_id', Auth::id())
            ->with('level.region')
            ->orderBy('earned_at', 'desc')
            ->get();

        return view('album.index', compact('memories'));
    }
}
