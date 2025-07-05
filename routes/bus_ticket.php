<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusTicketController;
use App\Http\Controllers\BusScheduleController;

Route::middleware("auth")->group(function () {
    Route::post("/bus/schedules", [BusScheduleController::class, "search"]);
    Route::post("/bus/ticket", [BusTicketController::class, "order"]);
    Route::get("/bus/ticket/payment", [BusTicketController::class, "payment"]);
    Route::post("/bus/ticket/pay", [BusTicketController::class, "pay"]);
    Route::get("/bus/ticket/finished", [BusTicketController::class, "receipt"]);
});