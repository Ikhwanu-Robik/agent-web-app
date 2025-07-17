<?php

namespace App\Http\Controllers\resources;

use App\Models\Game;
use App\Models\TopUpPackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\resources\TopUpPackagesController;

class GameTopUpPackagesController extends Controller
{
    public function index()
    {
        $result_packages = null;

        return view('master.packages', ['packages' => $result_packages, 'games' => Game::all()]);
    }

    public function create()
    {
        $games = Game::all();
        return view('master.create-package', ['games' => $games]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'game_id' => 'required|exists:games,id',
            'title' => 'required',
            'item' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:10000'
        ]);

        TopUpPackage::create([
            'game_id' => $validated['game_id'],
            'title' => $validated['title'],
            'items_count' => $validated['item'],
            'price' => $validated['price']
        ]);

        return redirect()->route('master.packages');
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
