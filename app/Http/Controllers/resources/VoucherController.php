<?php

namespace App\Http\Controllers\resources;

use App\Models\User;
use App\Models\Voucher;
use App\Enums\ValidService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVoucherRequest;
use App\Http\Requests\UpdateVoucherRequest;

class VoucherController extends Controller
{

    public function index()
    {
        $vouchers = Voucher::all();

        return view("master.vouchers.vouchers", ["vouchers" => $vouchers]);
    }

    public function create()
    {
        $users = User::all(["id", "name"]);

        return view("master.vouchers.create", ["users" => $users, "validServices" => array_column(ValidService::cases(), "value")]);
    }

    public function store(StoreVoucherRequest $storeVoucherRequest)
    {
        Voucher::createSpecial($storeVoucherRequest->validated());

        return redirect("/master/vouchers");
    }

    public function edit(Request $request, Voucher $voucher)
    {
        $users = User::all(["id", "name"]);

        return view("master.vouchers.edit", ["voucher" => $voucher, "validServices" => array_column(ValidService::cases(), "value"), "users" => $users]);
    }

    public function update(UpdateVoucherRequest $updateVoucherRequest, Voucher $voucher)
    {
        $voucher->update($updateVoucherRequest->validated());

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
