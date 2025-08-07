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
        $bpjsPrices = BpjsPrice::all();

        return view("master.bpjs-price.bpjs-price", ["bpjsPrices" => $bpjsPrices]);
    }

    public function create()
    {
        return view("master.bpjs-price.create");
    }

    public function store(StoreBpjsPriceRequest $storeBpjsPriceRequest)
    {
        BpjsPrice::create($storeBpjsPriceRequest->validated());

        return redirect("/master/bpjs/prices");
    }

    public function edit(BpjsPrice $bpjsPrice)
    {
        return view("master.bpjs-price.edit", ["bpjsPrice" => $bpjsPrice]);
    }

    public function update(UpdateBpjsPriceRequest $updateBpjsPriceRequest, BpjsPrice $bpjsPrice)
    {
        $bpjsPrice->update($updateBpjsPriceRequest->validated());

        return redirect("/master/bpjs/prices");
    }

    public function delete(BpjsPrice $bpjsPrice)
    {
        return view("master.bpjs-price.delete", ["bpjsPrice" => $bpjsPrice]);
    }

    public function destroy(Request $request, BpjsPrice $bpjsPrice)
    {
        $bpjsPrice->delete();

        return redirect("/master/bpjs/prices");
    }
}
