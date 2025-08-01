<?php

namespace App\Http\Controllers\resources;

use App\Http\Requests\StoreBpjsPriceRequest;
use App\Http\Requests\UpdateBpjsPriceRequest;
use App\Models\BpjsPrice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BpjsPriceController extends Controller
{
    public function index()
    {
        $bpjs_prices = BpjsPrice::all();

        return view("master.bpjs_price.bpjs_price", ["bpjs_prices" => $bpjs_prices]);
    }

    public function create()
    {
        return view("master.bpjs_price.create");
    }

    public function store(StoreBpjsPriceRequest $storeBpjsPriceRequest)
    {
        BpjsPrice::create($storeBpjsPriceRequest->validated());

        return redirect("/master/bpjs/prices");
    }

    public function edit(BpjsPrice $bpjs_price)
    {
        return view("master.bpjs_price.edit", ["bpjs_price" => $bpjs_price]);
    }

    public function update(UpdateBpjsPriceRequest $updateBpjsPriceRequest, BpjsPrice $bpjs_price)
    {
        $validated = $updateBpjsPriceRequest->validated();

        $bpjs_price->class = $validated["class"];
        $bpjs_price->price = $validated["price"];
        $bpjs_price->save();

        return redirect("/master/bpjs/prices");
    }

    public function delete(BpjsPrice $bpjs_price)
    {
        return view("master.bpjs_price.delete", ["bpjs_price" => $bpjs_price]);
    }

    public function destroy(Request $request, BpjsPrice $bpjs_price)
    {
        $bpjs_price->delete();

        return redirect("/master/bpjs/prices");
    }
}
