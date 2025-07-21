<?php

namespace App\Http\Controllers\resources;

use App\Models\Game;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class GameController extends Controller
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
            'name' => 'required|string',
            'icon' => 'required|image',
            'currency' => 'required|string'
        ]);

        $path_name = $request->file('icon')->storePublicly('game_icons');

        Game::create([
            'name' => $validated['name'],
            'icon' => $path_name,
            'currency' => $validated['currency']
        ]);

        return redirect("/master/games");
    }

    public function edit(Game $game)
    {
        return view("master.games.edit", ["game" => $game]);
    }

    public function update(Request $request, Game $game)
    {
        $validated = $request->validate([
            "name" => "required|string",
            "icon" => "required|image",
            "currency" => "required|string"
        ]);

        // TODO: confirm deletion of the old image
        Storage::disk("public")->delete($game->icon);
        $path_name = $request->file('icon')->storePublicly('game_icons');

        $game->name = $validated["name"];
        $game->icon = $path_name;
        $game->currency = $validated["currency"];
        $game->save();

        return redirect("/master/games");
    }

    public function delete(Game $game)
    {
        return view("master.games.delete", ["game" => $game]);
    }

    public function destroy(Request $request, Game $game)
    {
        $validated = $request->validate([
            "game" => "required|numeric|exists:games,id"
        ]);

        if (!$game) {
            return response("The given game is invalid", 422);
        }
        $game->delete();

        return redirect("/master/games");
    }
}
