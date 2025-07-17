<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\utilities\BusTicketController;
use App\Http\Controllers\views\BusTicketViewController;
use App\Http\Controllers\utilities\BusScheduleController;

Route::middleware("auth")->group(function () {
    Route::post("/bus/schedules", [BusScheduleController::class, "search"]);
    Route::post("/bus/ticket", [BusTicketController::class, "order"]);
    Route::get("/bus/ticket/payment", [BusTicketViewController::class, "busPayment"]);
    Route::post("/bus/ticket/pay", [BusTicketController::class, "pay"]);
    Route::get("/bus/ticket/finished", [BusTicketViewController::class, "busReceipt"]);
});