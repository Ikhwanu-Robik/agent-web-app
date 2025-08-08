<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\businesses\BusTicketTransactionController;
use App\Http\Controllers\views\BusTicketViewController;

Route::middleware("auth")->group(function () {
    Route::post("/bus/schedules", [BusTicketTransactionController::class, "search"])
        ->name("bus_ticket_transaction.find_package");
    Route::post("/bus/ticket", [BusTicketTransactionController::class, "order"])
        ->name("bus_ticket_transaction.order");
    Route::get("/bus/ticket/payment", [BusTicketViewController::class, "busPayment"])
        ->name("bus_ticket_transaction.select_payment_method");
    Route::post("/bus/ticket/pay", [BusTicketTransactionController::class, "pay"])
        ->name("bus_ticket_transaction.pay");
    Route::get("/bus/ticket/receipt", [BusTicketViewController::class, "busReceipt"])
        ->name("bus_ticket_transaction.receipt");
});