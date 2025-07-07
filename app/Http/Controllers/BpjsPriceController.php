<?php

namespace App\Http\Controllers;

use App\Models\BpjsPrice;
use Illuminate\Http\Request;

class BpjsPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bpjs_prices = BpjsPrice::all();

        return view("master.bpjs_price.bpjs_price", ["bpjs_prices" => $bpjs_prices]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("master.bpjs_price.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "class" => "required|numeric|unique:bpjs_prices,class",
            "price" => "required|numeric"
        ]);

        BpjsPrice::create($validated);

        return redirect("/master/bpjs/prices");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BpjsPrice $bpjs_price)
    {
        return view("master.bpjs_price.edit", ["bpjs_price" => $bpjs_price]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BpjsPrice $bpjs_price)
    {
        $validated = $request->validate([
            "class" => "required|numeric|unique:bpjs_prices,class",
            "price" => "required|numeric"
        ]);

        $bpjs_price->class = $validated["class"];
        $bpjs_price->price = $validated["price"];
        $bpjs_price->save();

        return redirect("/master/bpjs/prices");
    }

    public function delete(BpjsPrice $bpjs_price)
    {
        return view("master.bpjs_price.delete", ["bpjs_price" => $bpjs_price]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, BpjsPrice $bpjs_price)
    {
        $validated = $request->validate([
            "bpjs_price" => "required|numeric|exists:bpjs_prices,id"
        ]);

        $bpjs_price->delete();

        return redirect("/master/bpjs/prices");
    }
}
