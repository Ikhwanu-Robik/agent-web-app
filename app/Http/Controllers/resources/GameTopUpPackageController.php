<?php

namespace App\Http\Controllers\resources;

use App\Models\Game;
use App\Models\GameTopUpPackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GameTopUpPackageController extends Controller
{
    public function index()
    {
        $packages = GameTopUpPackage::all();
        return view('master.games.packages.index', ['packages' => $packages]);
    }

    public function create()
    {
        $games = Game::all();
        return view('master.games.packages.create', ['games' => $games]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'game_id' => 'required|exists:games,id',
            'title' => 'required',
            'items_count' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:10000'
        ]);

        GameTopUpPackage::create([
            'game_id' => $validated['game_id'],
            'title' => $validated['title'],
            'items_count' => $validated['items_count'],
            'price' => $validated['price']
        ]);

        return redirect("/master/games/packages");
    }

    public function edit(GameTopUpPackage $package)
    {
        return view("master.games.packages.edit", ["package" => $package, "games" => Game::all()]);
    }

    public function update(Request $request, GameTopUpPackage $package)
    {
        $validated = $request->validate([
            'game_id' => 'required|exists:games,id',
            'title' => 'required',
            'items_count' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:10000'
        ]);

        $package->game_id = $validated["game_id"];
        $package->title = $validated["title"];
        $package->items_count = $validated["items_count"];
        $package->price = $validated["price"];
        $package->save();

        return redirect("/master/games/packages");
    }

    public function delete(GameTopUpPackage $package)
    {
        return view("master.games.packages.delete", ["package" => $package]);
    }

    public function destroy(Request $request, GameTopUpPackage $package)
    {
        $validated = $request->validate([
            "package" => "required|numeric|exists:game_topup_packages,id"
        ]);

        if (!$package) {
            return response("The given package is invalid", 422);
        }
        $package->delete();

        return redirect("/master/games/packages");
    }
}
