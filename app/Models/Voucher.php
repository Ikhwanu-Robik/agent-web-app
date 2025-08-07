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

    public static function getValidVouchers(string $serviceName)
    {
        $vouchers = Voucher::where("user_id", "=", Auth::id())->get();
        $validVouchers = [];
        foreach ($vouchers as $voucher) {
            $validServices = json_decode($voucher->valid_for);

            foreach ($validServices as $service) {
                if ($service == $serviceName) {
                    array_push($validVouchers, $voucher);
                }
            }
        }

        return $validVouchers;
    }
}
