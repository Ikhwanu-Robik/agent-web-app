<?php

namespace App\Http\Controllers\resources;

use App\Http\Requests\StoreVoucherRequest;
use App\Http\Requests\UpdateVoucherRequest;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VoucherController extends Controller
{
    public static $valid_services = [
        "bus_ticket",
        "bpjs",
        "power",
        "film_ticket",
        "game_top_up"
    ];

    public function index()
    {
        $vouchers = Voucher::all();

        return view("master.vouchers.vouchers", ["vouchers" => $vouchers]);
    }

    public function create()
    {
        $users = User::all(["id", "name"]);

        return view("master.vouchers.create", ["users" => $users, "valid_services" => self::$valid_services]);
    }

    public function store(StoreVoucherRequest $storeVoucherRequest)
    {
        $validated = $storeVoucherRequest->validated();

        $user = User::findOrFail($validated["user_id"], ["id"]);

        $attributes = [
            "off_percentage" => $validated["off_percentage"],
            "valid_for" => json_encode($validated["valid_for"]),
            "user_id" => $user->id
        ];
        Voucher::create($attributes);

        return redirect("/master/vouchers");
    }

    public function edit(Request $request, Voucher $voucher)
    {
        $users = User::all(["id", "name"]);

        return view("master.vouchers.edit", ["voucher" => $voucher, "valid_services" => self::$valid_services, "users" => $users]);
    }

    public function update(UpdateVoucherRequest $updateVoucherRequest, Voucher $voucher)
    {
        $validated = $updateVoucherRequest->validated();

        $user = User::findOrFail($validated["user_id"]);

        $voucher->off_percentage = $validated["off_percentage"];
        $voucher->valid_for = json_encode($validated["valid_for"]);
        $voucher->user_id = $user->id;
        $voucher->saveOrFail();

        return redirect("/master/vouchers");
    }

    public function delete(Voucher $voucher)
    {
        return view("master.vouchers.delete", ["voucher" => Voucher::with("user")->find($voucher->id)]);
    }

    public function destroy(Request $request, Voucher $voucher)
    {
        $voucher->delete();

        return redirect("/master/vouchers");
    }
}
