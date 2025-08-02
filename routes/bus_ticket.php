<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\businesses\BusTicketTransactionController;
use App\Http\Controllers\views\BusTicketViewController;

Route::middleware("auth")->group(function () {
    Route::post("/bus/schedules", [BusTicketTransactionController::class, "search"]);
    Route::post("/bus/ticket", [BusTicketTransactionController::class, "order"]);
    Route::get("/bus/ticket/payment", [BusTicketViewController::class, "busPayment"]);
    Route::post("/bus/ticket/pay", [BusTicketTransactionController::class, "pay"]);
    Route::get("/bus/ticket/finished", [BusTicketViewController::class, "busReceipt"]);
});