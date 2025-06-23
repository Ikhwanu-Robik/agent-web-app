<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index()
    {
        return view("master.bus.bus", ["buses" => Bus::all()]);
    }

    public function create()
    {
        return view("master.bus.create");
    }

    public function store(Request $request)
    {
        $validated = $request->validate(["name" => "required|string"]);

        Bus::create($validated);

        return redirect("/master/bus");
    }

    public function edit(Bus $bus)
    {
        return view("master.bus.edit", ["bus" => $bus]);
    }

    public function update(Request $request, Bus $bus)
    {
        $validated = $request->validate(["name" => "required|string"]);

        $bus->name = $validated["name"];
        $bus->save();

        return redirect("/master/bus");
    }

    public function delete(Bus $bus) {
        return view("master.bus.delete", ["bus" => $bus]);
    }

    public function destroy(Request $request, Bus $bus)
    {
        $validated = $request->validate([
            "bus" => "required|numeric|exists:buses,id"
        ]);

        $bus->delete();

        return redirect("/master/bus");
    }
}
