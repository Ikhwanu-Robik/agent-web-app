<?php

namespace App\Http\Controllers\resources;

use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
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

    public function store(StoreGameRequest $storeGameRequest)
    {
        Game::createSpecial($storeGameRequest);

        return redirect("/master/games");
    }

    public function edit(Game $game)
    {
        return view("master.games.edit", ["game" => $game]);
    }

    public function update(UpdateGameRequest $updateGameRequest, Game $game)
    {
        $game->deleteImage();
        $game->saveImage($updateGameRequest->file("icon"));
        $game->updateSpecial($updateGameRequest->validated());

        return redirect("/master/games");
    }

    public function delete(Game $game)
    {
        return view("master.games.delete", ["game" => $game]);
    }

    public function destroy(Request $request, Game $game)
    {
        $game->delete();

        return redirect("/master/games");
    }
}
