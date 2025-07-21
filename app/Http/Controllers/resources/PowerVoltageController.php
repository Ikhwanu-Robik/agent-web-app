<?php

namespace App\Http\Controllers\resources;

use App\Http\Controllers\Controller;
use App\Models\PowerVoltage;
use Illuminate\Http\Request;

class PowerVoltageController extends Controller
{
    public function index()
    {
        $power_voltages = PowerVoltage::all();
        return view('master.power_voltages.index', ['power_voltages' => $power_voltages]);
    }

    public function create()
    {
        return view('master.power_voltages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'volts' => 'required|numeric',
            'monthly_price' => 'required|decimal:0,6',
        ]);

        PowerVoltage::create([
            'volts' => $validated['volts'],
            'monthly_price' => $validated['monthly_price']
        ]);

        return redirect("/master/power/voltages");
    }

    public function edit(PowerVoltage $power_voltage)
    {
        return view("master.power_voltages.edit", ["power_voltage" => $power_voltage]);
    }

    public function update(Request $request, PowerVoltage $power_voltage)
    {
        $validated = $request->validate([
            'volts' => 'required|numeric',
            'monthly_price' => 'required|decimal:0,6'
        ]);

        $power_voltage->volts = $validated["volts"];
        $power_voltage->monthly_price = $validated["monthly_price"];
        $power_voltage->save();

        return redirect("/master/power/voltages");
    }

    public function delete(PowerVoltage $power_voltage)
    {
        return view("master.power_voltages.delete", ["power_voltage" => $power_voltage]);
    }

    public function destroy(Request $request, PowerVoltage $power_voltage)
    {
        $validated = $request->validate([
            "power_voltage" => "required|numeric|exists:power_voltages,id"
        ]);

        if (!$power_voltage) {
            return response("The given power voltage record is invalid", 422);
        }
        $power_voltage->delete();

        return redirect("/master/power/voltages");
    }
}
