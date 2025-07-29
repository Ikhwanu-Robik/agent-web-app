<?php

namespace App\Services;

use App\Enums\FlipStep;
use App\Enums\FlipBillType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FlipTransaction
{
    public function createFlipBill(string $title, FlipBillType $flipBillType, int $amount, FlipStep $step, string $redirectUrl)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . config('flip.api_key'),
            'Content-Type' => 'application/x-www-form-urlencoded',
        ])
            ->asForm()  // Set the request content type to x-www-form-urlencoded
            ->post('https://bigflip.id/big_sandbox_api/v2/pwf/bill', [
                'title' => $title,
                'type' => $flipBillType->value,
                'amount' => $amount,
                'expired_date' => '',
                'redirect_url' => config('app.url') . $redirectUrl,
                'is_address_required' => '',
                'is_phone_number_required' => '',
                'step' => $step->value,
                'sender_name' => '',
                'sender_email' => '',
                'sender_phone_number' => '',
                'sender_address' => '',
                'sender_bank' => '',
                'sender_bank_type' => '',
            ]);

// Response example
// {
//     "link_id": 1,
//     "link_url": "flip.id/company-name/item",
//     "title": "Item Title",
//     "amount": 65000,
//     "redirect_url": "/receipt",
//     "expired_date": "01-01-1970",
//     "created_from": "API",
//     "status": "ACTIVE",
//     "is_address_required": 0,
//     "is_phone_number_required": 0,
//     "step": 1
// }            
        return $response;
    }

    public function getFlipPayment(string $bill_link_id)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . config('flip.api_key'),
            'Accept' => 'application/json'
        ])->get("https://bigflip.id/big_sandbox_api/v2/pwf/{$bill_link_id}/payment");

        return $response;
    }
}