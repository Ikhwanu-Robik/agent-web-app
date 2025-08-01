<?php

namespace App\Http\Controllers\resources;

use App\Http\Requests\StoreTopUpPackageRequest;
use App\Http\Requests\UpdateTopUpPackageRequest;
use Closure;
use App\Models\Game;
use Illuminate\Http\Request;
use App\Models\GameTopUpPackage;
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

    public function store(StoreTopUpPackageRequest $storeTopUpPackageRequest)
    {
        GameTopUpPackage::create($storeTopUpPackageRequest->validated());

        return redirect("/master/games/packages");
    }

    public function edit(GameTopUpPackage $package)
    {
        return view("master.games.packages.edit", ["package" => $package, "games" => Game::all()]);
    }

    public function update(UpdateTopUpPackageRequest $updateTopUpPackageRequest, GameTopUpPackage $package)
    {
        $package->update($updateTopUpPackageRequest->validated());

        return redirect("/master/games/packages");
    }

    public function delete(GameTopUpPackage $package)
    {
        return view("master.games.packages.delete", ["package" => $package]);
    }

    public function destroy(Request $request, GameTopUpPackage $package)
    {
        $package->delete();

        return redirect("/master/games/packages");
    }
}
