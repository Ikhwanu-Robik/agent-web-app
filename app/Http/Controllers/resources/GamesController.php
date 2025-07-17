<?php

namespace App\Http\Controllers\resources;

use App\Models\Game;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GamesController extends Controller
{
    public function index()
    {
        $games = Game::all();

        return view('master.games.index', ['games' => $games]);
    }

    public function create()
    {
        return view('master.games.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'icon' => 'required',
            'currency' => 'required'
        ]);

        $path_name = $request->file('icon')->storePublicly('game_icons');

        Game::create([
            'name' => $validated['name'],
            'icon' => $path_name,
            'currency' => $validated['currency']
        ]);

        return redirect()->route('master.games.index');
    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }

    public function destroy()
    {

    }
}
