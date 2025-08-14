<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\businesses\BusTicketTransactionController;
use App\Http\Controllers\views\BusTicketViewController;

Route::middleware("auth")->group(function () {
    Route::get("/bus/schedules", [BusTicketViewController::class, "showSearchBusScheduleForm"])
        ->name("bus_ticket_transaction.select_schedule");
    Route::post("/bus/schedules", [BusTicketTransactionController::class, "search"])
        ->name("bus_ticket_transaction.find_schedule");
    Route::post("/bus/schedules/{schedule}", [BusTicketTransactionController::class, "order"])
        ->name("bus_ticket_transaction.order");
    Route::get("/bus/schedules/{schedule}/select-payment", [BusTicketViewController::class, "showPaymentForm"])
        ->name("bus_ticket_transaction.select_payment_method");
    Route::post("/bus/schedules/{schedule}/pay", [BusTicketTransactionController::class, "pay"])
        ->name("bus_ticket_transaction.pay");
    Route::get("/bus/schedules/{schedule}/receipt", [BusTicketViewController::class, "showReceipt"])
        ->name("bus_ticket_transaction.receipt");
});