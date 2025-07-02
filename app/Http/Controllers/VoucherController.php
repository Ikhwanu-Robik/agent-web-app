<?php

namespace App\Http\Controllers;

use Log;
use Closure;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Queue\Middleware\Skip;

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

    public function store(Request $request)
    {
        $validated = $request->validate([
            "off_percentage" => "required|numeric",
            "valid_for" => [
                "required",
                "array",
                function (string $attribute, mixed $value, Closure $fail) {
                    // Check if all element of $input is also element of $valid_services
                    $isAllInputValidServices = false;

                    $validCount = 0;
                    foreach ($value as $service) {
                        foreach (self::$valid_services as $valid) {
                            if ($service == $valid) {
                                $validCount++;
                                break;
                            }
                        }
                    }

                    if (count($value) != $validCount) {
                        $isAllInputValidServices = false;
                    } else if (count($value) == $validCount) {
                        $isAllInputValidServices = true;
                    }

                    if (!$isAllInputValidServices) {
                        $fail("The " . $attribute . " contains invalid service");
                    }
                }
            ],
            "user_id" => "required|numeric|max:100"
        ]);

        $user = User::findOrFail($validated["user_id"], ["id"]);

        $attributes = [
            "off_percentage" => $validated["off_percentage"],
            "valid_for" => json_encode($validated["valid_for"]),
            "user_id" => $user->id
        ];
        Voucher::create($attributes);

        return redirect("/master/vouchers");
    }
}
