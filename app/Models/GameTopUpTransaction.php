<?php

namespace App\Models;

use App\Enums\FlipStep;
use App\Models\Voucher;
use App\Enums\FlipBillType;
use App\Models\GameTopUpPackage;
use App\Services\FlipTransaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class GameTopUpTransaction extends Model
{
    protected $table = "game_topup_transactions";

    protected $fillable = [
        'user_id',
        'package_id',        
        'total',
        'method',
        'status',
        'flip_link_id',
    ];

    public function topUpPackage() {
        return $this->belongsTo(GameTopUpPackage::class, "package_id", "id");
    }

    public static function createOrder(array $validated, GameTopUpPackage $package)
    {
        return self::make([
            "user_id" => Auth::id(),
            "package_id" => $validated["game_topup_package_id"],
            "total" => $package->price,
            "method" => null,
            "status" => null,
            "flip_link_id" => null
        ]);
    }

    public function calculateTotal($voucher_id)
    {
        $voucher = Voucher::find($voucher_id);
        $discount = 1;
        if ($voucher_id != -1) {
            $discount = (100 - $voucher->off_percentage) / 100;

            $voucher->delete();
        }

        $this->total = $this->total * $discount;
        
        return $voucher;
    }

    public function processPayment(FlipTransaction $flipTransaction, GameTopUpPackage $package, $validated)
    {
        $voucher = $this->calculateTotal($validated["voucher"]);

        $this->method = $validated["payment_method"];
        $this->status = "PENDING";

        $flipResponse = null;

        if ($validated["payment_method"] == "cash") {
            $this->status = "SUCCESSFUL";
        } else if ($validated["payment_method"] == "flip") {
            $response = $flipTransaction->createFlipBill(
                "Game Top Up - {$package->game->name} - {$package->title} - {$package->items_count} {$package->game->currency}",
                FlipBillType::SINGLE,
                $this->total,
                FlipStep::INPUT_DATA,
                "/game/topup"
            );

            $flipResponse = $response;
        }

        $this->flip_link_id = $flipResponse ? $flipResponse["link_id"] : null;
        $this->save();

        if ($voucher) {
            $this->voucher = $voucher->off_percentage . "%";
        }

        return $flipResponse;
    }
}
