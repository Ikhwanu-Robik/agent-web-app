<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        "off_percentage",
        "valid_for",
        "user_id"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function createSpecial(array $attributes)
    {
        Voucher::create([
            "off_percentage" => $attributes["off_percentage"],
            "valid_for" => json_encode($attributes["valid_for"]),
            "user_id" => $attributes["user_id"]
        ]);
    }

    public static function getValidVouchers(string $service_name)
    {
        $vouchers = Voucher::where("user_id", "=", Auth::id())->get();
        $valid_vouchers = [];
        foreach ($vouchers as $voucher) {
            $valid_services = json_decode($voucher->valid_for);

            foreach ($valid_services as $service) {
                if ($service == $service_name) {
                    array_push($valid_vouchers, $voucher);
                }
            }
        }

        return $valid_vouchers;
    }
}
