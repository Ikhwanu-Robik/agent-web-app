<?php

namespace App\Http\Controllers\resources;

use App\Http\Requests\StoreBusRequest;
use App\Http\Requests\UpdateBusRequest;
use App\Models\Bus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    public function store(StoreBusRequest $storeBusRequest)
    {
        Bus::create($storeBusRequest->validated());

        return redirect("/master/bus");
    }

    public function edit(Bus $bus)
    {
        return view("master.bus.edit", ["bus" => $bus]);
    }

    public function update(UpdateBusRequest $updateBusRequest, Bus $bus)
    {
        $validated = $updateBusRequest->validated();

        $bus->name = $validated["name"];
        $bus->save();

        return redirect("/master/bus");
    }

    public function delete(Bus $bus) {
        return view("master.bus.delete", ["bus" => $bus]);
    }

    public function destroy(Request $request, Bus $bus)
    {
        $bus->delete();

        return redirect("/master/bus");
    }
}
